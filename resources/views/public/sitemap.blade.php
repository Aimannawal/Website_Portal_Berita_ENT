{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('public.index') }}</loc>
        <changefreq>hourly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach ($berita as $item)
    <url>
        <loc>{{ route('public.berita.show', $item->slug) }}</loc>
        <lastmod>{{ ($item->updated_at ?? $item->published_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @foreach ($artikel as $item)
    <url>
        <loc>{{ route('public.artikel.show', $item->slug) }}</loc>
        <lastmod>{{ ($item->updated_at ?? $item->published_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
