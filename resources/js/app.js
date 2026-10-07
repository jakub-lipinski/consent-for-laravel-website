// Native dialogs provide modality; keep tab navigation inside their controls.
document.querySelectorAll('dialog').forEach(dialog => {
    dialog.addEventListener('keydown', event => {
        if (event.key !== 'Tab') return;
        const controls = [...dialog.querySelectorAll('a[href], button, input, select, textarea, [tabindex]')]
            .filter(element => !element.disabled && element.tabIndex >= 0 && element.getClientRects().length);
        const first = controls[0], last = controls.at(-1);
        if (!first) return;
        const active = document.activeElement;
        if (event.shiftKey && (active === first || !controls.includes(active))) {
            event.preventDefault(); last.focus();
        } else if (!event.shiftKey && (active === last || !dialog.contains(active))) {
            event.preventDefault(); first.focus();
        }
    });
});
const status = document.querySelector('[data-site-status]');
const announce = (message) => { if (status) status.textContent = message; };
const restoreFocus = (opener) => { if (opener?.isConnected) opener.focus({ preventScroll: true }); };
const outsideDialog = (event, dialog) => {
    const bounds = dialog.getBoundingClientRect();
    return event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom);
};
const search = document.querySelector('[data-search-dialog]');
if (search && typeof search.showModal === 'function') {
    const input = search.querySelector('[data-search-input]');
    const results = search.querySelector('[data-search-results]');
    const message = search.querySelector('[data-search-status]');
    let opener, index = null, loading = false;
    const render = () => {
        results.replaceChildren();
        const words = input.value.toLocaleLowerCase().trim().split(/\s+/).filter(Boolean);
        if (!index) return;
        if (!words.length) { message.textContent = 'Type a word or a question.'; return; }
        const matches = index.map(page => {
            const title = page.title.toLocaleLowerCase();
            const body = `${page.title} ${page.description} ${page.content}`.toLocaleLowerCase();
            return { page, score: words.every(word => body.includes(word)) ? 1 + words.filter(word => title.includes(word)).length * 10 : 0 };
        }).filter(item => item.score).sort((a,b) => b.score-a.score).slice(0,8);
        message.textContent = matches.length ? `${matches.length} ${matches.length === 1 ? 'result' : 'results'}. Use Tab to open a chapter.` : 'No results. Try a shorter term, such as cookie or Blade.';
        for (const { page } of matches) {
            const li = document.createElement('li'), a = document.createElement('a'), section = document.createElement('span'), title = document.createElement('strong'), description = document.createElement('p');
            a.href = page.url; section.textContent = page.section; title.textContent = page.title; description.textContent = page.description;
            a.append(section,title,description); li.append(a); results.append(li);
        }
    };
    const load = async () => {
        if (index || loading) return;
        loading = true; message.textContent = 'Loading documentation...';
        try {
            const response = await fetch(search.dataset.searchUrl, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('Search unavailable');
            index = await response.json(); render();
        } catch {
            message.textContent = 'Search could not load. Close and reopen to try again. All chapters remain available in the documentation navigation.';
        } finally { loading = false; }
    };
    const open = (trigger) => {
        if (document.querySelector('dialog[open]')) return;
        opener = trigger || document.activeElement; search.showModal(); input.focus(); load();
    };
    document.querySelectorAll('[data-search-open]').forEach(button => { button.hidden = false; button.addEventListener('click', () => open(button)); });
    search.querySelector('[data-search-close]').addEventListener('click', () => search.close());
    search.addEventListener('click', event => { if (outsideDialog(event, search)) search.close(); });
    search.addEventListener('close', () => restoreFocus(opener));
    input.addEventListener('input', render);
    document.addEventListener('keydown', event => {
        if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k' && !event.altKey && !event.shiftKey) {
            if (!document.querySelector('dialog[open]')) { event.preventDefault(); open(); }
        }
    });
}
document.querySelectorAll('.docs-prose pre').forEach(pre => {
    const code = pre.querySelector('code');
    if (!code) return;
    const language = [...code.classList].find(name => name.startsWith('language-'))?.replace('language-', '') || 'Code';
    const wrapper = document.createElement('div'), toolbar = document.createElement('div'), label = document.createElement('span'), button = document.createElement('button');
    wrapper.className = 'code-wrapper'; toolbar.className = 'code-toolbar'; label.textContent = language; button.className = 'copy-button'; button.type = 'button'; button.textContent = 'Copy'; button.setAttribute('aria-label', `Copy ${language} code`);
    toolbar.append(label,button); pre.before(wrapper); wrapper.append(toolbar,pre);
    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(code.textContent); button.textContent = 'Copied'; announce('Code copied to clipboard.');
            setTimeout(() => { button.textContent = 'Copy'; }, 2000);
        } catch { announce('Copy is unavailable. Select the code and copy it manually.'); }
    });
    pre.tabIndex = 0; pre.setAttribute('aria-label', `${language} code example`);
});
document.querySelectorAll('.docs-prose table').forEach(table => {
    if (table.parentElement.classList.contains('table-wrapper')) return;
    const wrapper = document.createElement('div'); wrapper.className = 'table-wrapper'; table.before(wrapper); wrapper.append(table);
    if (wrapper.scrollWidth > wrapper.clientWidth) { wrapper.tabIndex = 0; wrapper.setAttribute('role', 'region'); wrapper.setAttribute('aria-label', 'Reference table, horizontally scrollable'); }
});
const chapters = document.querySelector('[data-doc-navigation]');
if (chapters) {
    const desktop = matchMedia('(min-width: 801px)');
    const adjust = () => { chapters.open = desktop.matches; };
    adjust(); desktop.addEventListener('change', adjust);
}
if ('IntersectionObserver' in window) {
    const tocLinks = [...document.querySelectorAll('.docs-toc a')];
    const observer = new IntersectionObserver(entries => {
        const visible = entries.filter(entry => entry.isIntersecting).sort((a,b) => a.boundingClientRect.top-b.boundingClientRect.top)[0];
        if (!visible) return;
        tocLinks.forEach(link => { if (link.hash === `#${visible.target.id}`) link.setAttribute('aria-current','location'); else link.removeAttribute('aria-current'); });
    }, { rootMargin: '0px 0px -65% 0px' });
    document.querySelectorAll('[data-doc-content] h2, [data-doc-content] h3').forEach(heading => observer.observe(heading));
}
const preview = document.querySelector('[data-preview]');
if (preview) {
    const stage = preview.querySelector('[data-preview-stage]');
    const interfaceRoot = preview.querySelector('.consent-preview-ui');
    const banner = preview.querySelector('[data-preview-banner]');
    const reopen = preview.querySelector('[data-preview-reopen]');
    const reset = preview.querySelector('[data-preview-reset]');
    const message = preview.querySelector('[data-preview-status]');
    const dialog = preview.querySelector('[data-preview-dialog]');
    const form = dialog.querySelector('[data-preview-form]');
    const optionalFields = [...form.querySelectorAll('.consent-switch:not(:disabled)')];
    let choices = Object.fromEntries(optionalFields.map(field => [field.name, false]));
    let decided = false, dismissed = false, opener;

    const reveal = () => {
        banner.hidden = dialog.open || decided || dismissed;
        reopen.hidden = dialog.open || !banner.hidden;
    };
    const returnFocus = () => {
        restoreFocus(opener?.isConnected && !opener.closest('[hidden]') && !dialog.contains(opener) ? opener : reopen);
    };
    const close = () => {
        if (!dialog.open) return;
        dialog.close();
        reveal();
        returnFocus();
    };
    const choose = (next, summary) => {
        choices = next;
        decided = true;
        dismissed = false;
        message.textContent = `${summary} Preview only; nothing stored.`;
        if (dialog.open) close();
        else {
            reveal();
            reopen.focus({ preventScroll: true });
        }
    };
    const open = trigger => {
        if (typeof dialog.showModal !== 'function') {
            message.textContent = 'The preferences preview requires a browser with native dialog support.';
            return;
        }
        if (document.querySelector('dialog[open]')) return;
        opener = trigger;
        optionalFields.forEach(field => { field.checked = choices[field.name]; });
        dialog.showModal();
        reveal();
        dialog.scrollTop = 0;
        dialog.querySelector('h2').focus({ preventScroll: true });
    };

    preview.querySelector('.position-selector').disabled = false;
    banner.querySelectorAll('button').forEach(button => { button.disabled = false; });
    reset.hidden = false;
    preview.querySelectorAll('[name="preview-position"]').forEach(input => input.addEventListener('change', () => {
        stage.dataset.position = input.value;
        interfaceRoot.dataset.consentPosition = input.value;
        message.textContent = `Position changed to ${input.value.replace('bottom-', '')}. Preview only.`;
    }));
    preview.querySelectorAll('[data-preview-choice]').forEach(button => button.addEventListener('click', () => {
        const accept = button.dataset.previewChoice === 'all';
        choose(Object.fromEntries(optionalFields.map(field => [field.name, accept])), accept ? 'All categories accepted.' : 'Optional categories rejected.');
    }));
    preview.querySelector('[data-preview-preferences]').addEventListener('click', event => open(event.currentTarget));
    reopen.addEventListener('click', event => open(event.currentTarget));
    preview.querySelector('[data-preview-dismiss]').addEventListener('click', () => {
        dismissed = true;
        reveal();
        message.textContent = 'Notice closed without choosing. Preview only; nothing stored.';
        reopen.focus({ preventScroll: true });
    });
    dialog.querySelector('[data-preview-close]').addEventListener('click', close);
    dialog.addEventListener('cancel', event => { event.preventDefault(); close(); });
    dialog.addEventListener('click', event => { if (outsideDialog(event, dialog)) close(); });
    dialog.addEventListener('close', () => {
        const needsFocus = dialog.contains(document.activeElement) || document.activeElement === document.body;
        reveal();
        if (needsFocus) returnFocus();
    });
    form.addEventListener('submit', event => {
        event.preventDefault();
        choose(Object.fromEntries(optionalFields.map(field => [field.name, field.checked])), 'Preferences saved for this preview.');
    });
    reset.addEventListener('click', () => {
        choices = Object.fromEntries(optionalFields.map(field => [field.name, false]));
        decided = false;
        dismissed = false;
        reveal();
        message.textContent = 'Preview reset. No cookies or trackers.';
    });
}
