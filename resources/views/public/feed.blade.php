{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>NewsHub — Portal Berita ENT GEN 21</title>
        <link>{{ route('public.index') }}</link>
        <atom:link href="{{ route('public.feed') }}" rel="self" type="application/rss+xml"/>
        <description>Kabar terkini, artikel pilihan, dan sorotan mingguan dari redaksi NewsHub.</description>
        <language>id</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        @foreach ($items as $item)
        <item>
            <title>{{ $item['title'] }}</title>
            <link>{{ $item['link'] }}</link>
            <guid isPermaLink="true">{{ $item['link'] }}</guid>
            <description>{{ $item['description'] }}</description>
            @if ($item['category'])<category>{{ $item['category'] }}</category>@endif
            <pubDate>{{ $item['date']?->toRssString() }}</pubDate>
        </item>
        @endforeach
    </channel>
</rss>
