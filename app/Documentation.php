<?php

namespace App;

use Illuminate\Support\Str;

class Documentation
{
    /** @return array<string, list<array{slug: string, title: string, description: string}>> */
    public function navigation(): array
    {
        return config('site.documentation');
    }

    /** @return list<array{slug: string, title: string, description: string, section: string}> */
    public function pages(): array
    {
        $pages = [];
        foreach ($this->navigation() as $section => $items) {
            foreach ($items as $item) {
                $pages[] = [...$item, 'section' => $section];
            }
        }

        return $pages;
    }

    /** @return array{slug: string, title: string, description: string, section: string} */
    public function page(string $slug): array
    {
        foreach ($this->pages() as $page) {
            if ($page['slug'] === $slug) {
                return $page;
            }
        }

        abort(404);
    }

    public function markdown(string $slug): string
    {
        $page = $this->page($slug);
        $path = resource_path('markdown/docs/'.$page['slug'].'.md');
        abort_unless(is_file($path) && is_readable($path), 404);

        return (string) file_get_contents($path);
    }

    /** @return array{html: string, toc: list<array{level: int, title: string, id: string}>} */
    public function render(string $markdown): array
    {
        $html = Str::markdown($markdown, ['html_input' => 'strip', 'allow_unsafe_links' => false]);
        $toc = [];
        $used = [];
        $html = (string) preg_replace_callback('/<h([23])>(.*?)<\/h\1>/is', function (array $matches) use (&$toc, &$used): string {
            $title = html_entity_decode(strip_tags($matches[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $base = Str::slug($title) ?: 'section';
            $id = $base;
            $suffix = 1;
            while (isset($used[$id])) {
                $id = $base.'-'.++$suffix;
            }
            $used[$id] = true;
            $toc[] = ['level' => (int) $matches[1], 'title' => $title, 'id' => $id];

            return '<h'.$matches[1].' id="'.e($id).'" tabindex="-1">'.$matches[2].'</h'.$matches[1].'>';
        }, $html);

        $html = str_replace('<pre>', '<pre tabindex="0" aria-label="Code example">', $html);
        $html = (string) preg_replace('/(<table>.*?<\/table>)/s', '<div class="table-wrapper" role="region" tabindex="0" aria-label="Reference table">$1</div>', $html);

        return compact('html', 'toc');
    }

    /** @return list<array{slug: string, title: string, section: string, description: string, url: string, content: string}> */
    public function searchIndex(): array
    {
        return array_map(function (array $page): array {
            $html = Str::markdown($this->markdown($page['slug']), ['html_input' => 'strip', 'allow_unsafe_links' => false]);
            $content = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

            return [...$page, 'url' => route('docs.show', $page['slug']), 'content' => (string) preg_replace('/\s+/u', ' ', $content)];
        }, $this->pages());
    }
}
