<dialog id="documentation-search" class="search-dialog" aria-labelledby="search-title" data-search-dialog data-search-url="{{ route('docs.search') }}">
    <div class="search-heading"><h2 id="search-title">Find your way.</h2><button class="icon-button" type="button" data-search-close aria-label="Close documentation search"><x-icon name="close" /></button></div>
    <label for="documentation-query">Search the documentation</label>
    <div class="search-input-wrap"><x-icon name="search" /><input id="documentation-query" type="search" placeholder="Try categories, @@consent, or CSP" autocomplete="off" spellcheck="false" data-search-input></div>
    <p class="search-status" role="status" aria-live="polite" data-search-status>Type a word or a question.</p>
    <ul class="search-results" data-search-results aria-label="Search results"></ul>
    <p class="search-help">Use Tab to move through results. Escape closes search.</p>
</dialog>
