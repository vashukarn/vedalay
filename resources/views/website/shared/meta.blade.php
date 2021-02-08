<meta name="description" content="{{ @$meta->meta_desc}}">
<meta name="keywords" content="{{ @$meta->meta_key }}">
<meta property="og:title" content="{{ @$meta->title }}">
<meta property="og:image" content="{{ asset('/uploads/settings/' . @$meta->og_image) }}">
<meta property="og:description" content="{{ @$meta->meta_description }}">
<meta property="og:url" content="{{ __(env('APP_URL', 'http://shreevahan.com/')) }} " />
<meta name="twitter:card" content="{{ asset('/uploads/settings/' . @$meta->og_image) }}">
<meta name="twitter:site" content="{{ @$meta->twitter }}" />