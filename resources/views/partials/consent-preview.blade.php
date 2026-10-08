<div class="preview-workbench" data-preview>
    <div class="preview-stage" data-preview-stage data-position="bottom-left">
        <div class="preview-site">
            <div class="preview-site-header"><span class="preview-wordmark">Your Laravel app<span aria-hidden="true">.</span></span><span class="preview-site-label">Your next project</span></div>
            <div class="preview-site-content"><span class="eyebrow">A preview of your application</span><p>Your Laravel app<br><span class="text-accent">with consent</span></p><div class="preview-lines" aria-hidden="true"><span></span><span></span><span></span></div></div>
            <div class="preview-decoration" aria-hidden="true"><x-icon name="cookie" /><span>Preferences your<br>visitors control</span></div>
        </div>
        <div class="consent-ui consent-preview-ui" data-consent-position="bottom-left" data-consent-variant="standard" lang="en" dir="ltr">
            <section class="consent-banner" data-preview-banner aria-labelledby="preview-banner-title">
                <div class="consent-banner__content">
                    <div class="consent-heading">
                        <h2 id="preview-banner-title">Your privacy matters</h2>
                        <button type="button" class="consent-icon-button" data-preview-dismiss aria-label="Close cookie notice without choosing" disabled><x-icon name="close" /></button>
                    </div>
                    <p>We use necessary cookies to keep this website working. With your permission, we also use optional cookies for the purposes listed in preferences. You can change your choice at any time.</p>
                </div>
                <div class="consent-actions">
                    <button type="button" class="consent-button consent-button--choice" data-preview-choice="all" data-consent-action="accept" disabled>Accept all</button>
                    <button type="button" class="consent-button consent-button--choice" data-preview-choice="none" data-consent-action="reject" disabled>Reject optional</button>
                    <button type="button" class="consent-button" data-preview-preferences data-consent-action="open" aria-haspopup="dialog" aria-controls="preview-preferences" disabled>Manage preferences</button>
                </div>
            </section>
            <dialog id="preview-preferences" class="consent-dialog" data-preview-dialog aria-labelledby="preview-preferences-title" aria-modal="true">
                <form data-preview-form>
                    <header class="consent-heading">
                        <h2 id="preview-preferences-title" tabindex="-1">Cookie preferences</h2>
                        <button type="button" class="consent-icon-button" data-preview-close aria-label="Close preferences without saving"><x-icon name="close" /></button>
                    </header>
                    <p class="consent-description">Choose which optional categories you allow. Necessary cookies are always active. Only categories used on this website are shown.</p>
                    <fieldset class="consent-categories">
                        <legend class="consent-sr-only">Cookie categories</legend>
                        <div class="consent-category">
                            <div class="consent-category__heading">
                                <label for="preview-category-necessary">Necessary</label>
                                <span class="consent-category__required">Always active</span>
                                <input id="preview-category-necessary" class="consent-switch" type="checkbox" role="switch" name="necessary" aria-describedby="preview-description-necessary" checked disabled>
                            </div>
                            <p id="preview-description-necessary">Support essential website functions and remember your cookie preferences. They cannot be turned off here.</p>
                        </div>
                        <div class="consent-category">
                            <div class="consent-category__heading">
                                <label for="preview-category-analytics">Analytics</label>
                                <input id="preview-category-analytics" class="consent-switch" type="checkbox" role="switch" name="analytics" aria-describedby="preview-description-analytics">
                            </div>
                            <p id="preview-description-analytics">Help understand visits and how people use this website.</p>
                            <details class="consent-service-details" data-preview-services open>
                                <summary hidden>Services in this category</summary>
                                <ul class="consent-services" aria-label="Services in this category"><li><strong>Site analytics</strong><span>Measure visits and navigation to improve the website.</span></li></ul>
                            </details>
                        </div>
                        <div class="consent-category">
                            <div class="consent-category__heading">
                                <label for="preview-category-marketing">Marketing</label>
                                <input id="preview-category-marketing" class="consent-switch" type="checkbox" role="switch" name="marketing" aria-describedby="preview-description-marketing">
                            </div>
                            <p id="preview-description-marketing">Support advertising and measure campaign results.</p>
                            <details class="consent-service-details" data-preview-services open>
                                <summary hidden>Services in this category</summary>
                                <ul class="consent-services" aria-label="Services in this category"><li><strong>Campaign measurement</strong><span>Measure conversions from advertising campaigns.</span></li></ul>
                            </details>
                        </div>
                    </fieldset>
                    <footer class="consent-dialog__footer">
                        <div class="consent-actions">
                            <button type="button" class="consent-button consent-button--choice" data-preview-choice="all" data-consent-action="accept">Accept all</button>
                            <button type="button" class="consent-button consent-button--choice" data-preview-choice="none" data-consent-action="reject">Reject optional</button>
                            <button type="submit" class="consent-button" data-consent-action="save">Save preferences</button>
                        </div>
                    </footer>
                </form>
            </dialog>
            <button type="button" class="consent-launcher" data-preview-reopen hidden aria-label="Change cookie preferences" title="Change cookie preferences" aria-controls="preview-preferences" aria-haspopup="dialog"><x-icon name="cookie" /></button>
        </div>
    </div>
    <div class="preview-toolbar">
        <fieldset class="position-selector variant-selector" disabled>
            <legend>Interface variant</legend>
            <label><input type="radio" name="preview-variant" value="standard" checked><span>Standard</span></label>
            <label><input type="radio" name="preview-variant" value="compact"><span>Compact</span></label>
        </fieldset>
        <fieldset class="position-selector" disabled>
            <legend>Banner position</legend>
            <label><input type="radio" name="preview-position" value="bottom-left" checked><span><x-icon name="banner-left" /> Left</span></label>
            <label><input type="radio" name="preview-position" value="bottom-center"><span><x-icon name="banner-center" /> Center</span></label>
            <label><input type="radio" name="preview-position" value="bottom-right"><span><x-icon name="banner-right" /> Right</span></label>
        </fieldset>
        <button class="text-button" type="button" data-preview-reset hidden>Reset preview <x-icon name="refresh" /></button>
    </div>
    <noscript><p class="preview-noscript">The interactive preview requires JavaScript. The documentation and this static illustration remain available.</p></noscript>
    <div class="preview-caption"><p data-preview-status role="status" aria-live="polite">Preview only. No cookies or trackers.</p><a href="{{ route('docs.show', 'banner-and-theme') }}">Explore the options <x-icon name="arrow-right" /></a></div>
</div>
