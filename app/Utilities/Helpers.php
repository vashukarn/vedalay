<?php
//get unocde number
define('website_content_item', [
    [
        'value' => "news",
        'title' => "News",
    ],
    [
        'value' => "blogs", 
        'title' => "Blogs"
    ], 
    [
        'value' => "slider", 
        'title' => "Slider"
    ],
    [
        'value' => "information", 
        'title' => "Information"
    ],
    [
        'value' => "features", 
        'title' => "Features" 
    ],
    [
        'value' => "faq" ,
        'title' => "Faqs"
    ],
    [
        'value' => "testimonial", 
        'title' => "Testimonial"
    ]
]);

function getUnicodeNumber($input)
{
    $standard_numsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $nepali_numsets = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
    return str_replace($standard_numsets, $nepali_numsets, $input);
}

//get standarrd number
function getStandardNumber($input)
{
    $nepali_numsets = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
    $standard_numsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $result = str_replace($nepali_numsets, $standard_numsets, $input);
    return strtoupper(trim($result));
}

//Upload Image
function uploadFile($file, $dir, $thumb = null, $user_file = null)
{
    $path = public_path() . '/' . $dir;
    if (!File::exists($path)) {
        File::makedirectory($path, 0777, true, true);
    }
    // dd($path);
    // dd($user_file);
    if (!$file->getClientOriginalExtension()) {
        return false;
    }
    if ($user_file != null) {
        $file_name = $user_file . "_" . rand(1111, 9999) . "." . $file->getClientOriginalExtension();
    } else {
        $file_name = ucfirst($dir) . "-" . date('YmdHis') . rand(0, 9999) . "." . $file->getClientOriginalExtension();
    }
    if ($file_name) {
        $success = $file->move($path, $file_name);
        if ($success):
            if ($thumb) {
                list($width, $height) = explode('x', $thumb);
                Image::make($path . '/' . $file_name)->resize($width, $height, function ($constraints) {
                    return $constraints->aspectRatio();
                })->save($path . '/Thumb-' . $file_name);
            }
            return $file_name;
        else:
            return false;
        endif;
    }
}

//Delete Image
function deleteFile($file, $dir, $thumb = false)
{
    if (file_exists(public_path() . '/' . $dir . '/' . $file) && !empty($file)) {
        unlink(public_path() . '/' . $dir . '/' . $file);
        if (file_exists(public_path() . '/' . $dir . '/Thumb-' . $file)) {
            unlink(public_path() . '/' . $dir . '/Thumb-' . $file);
        }
    }
}

//map error message for API
function mapErrorMessage($validation)
{
    $errors = [];
    // dd($validation->messages());
    foreach ($validation->errors()->all() as $key => $message) {
        $errors[] = $message;
    }
    return $errors;
}

//English to Nepali date:datenep('2076-12-30') for 2046-03-14 or  datenep('2046-03-14',true) for  २०४६ असार १४ गते बुधबार;
function datenep($date, $num_date = null)
{
    $lib = new \App\Models\NepaliCalander();
    $date = str_replace('/', '-', $date);
    $a = explode("-", $date);
    $b = explode(" ", $a[2]);
    $cd = $lib->eng_to_nep($a[0], $a[1], $b[0]);
    $cd = (array) $cd;
    if ($num_date == true) {
        return $cd['year'] . " " . $cd['nmonth'] . " " . $cd['date'] . " गते " . $cd['day'];
    } else {
        (getStandardNumber($cd['month']) > 9) ? $m = $cd['month'] : $m = "0" . $cd['month'];
        (getStandardNumber($cd['date']) > 9) ? $d = $cd['date'] : $d = "0" . $cd['date'];
        return getStandardNumber($cd['year'] . "-" . $m . "-" . $d);
    }
}
//Nep to eng dateeng('2076-12-30') or dateeng(2076-12-30',true) for leading 0 & false for not leading 0
function dateeng($date, $lead = true)
{
    $lib = new \App\Models\NepaliCalander();
    $date = str_replace('/', '-', $date);
    $a = explode("-", $date);
    $b = explode(" ", $a[2]);
    $cd = $lib->nep_to_eng($a[0], $a[1], $b[0]);
    $cd = (array) $cd;
    if ($lead == false) { //return the leading zero date
        return $cd['year'] . "-" . $cd['month'] . "-" . $cd['date'];
    } else {
        ($cd['month'] > 9) ? $m = $cd['month'] : $m = "0" . $cd['month'];
        ($cd['date'] > 9) ? $d = $cd['date'] : $d = "0" . $cd['date'];
        return $cd['year'] . "-" . $m . "-" . $d;
    }
}

// profile image loader
function profileImage($image)
{
    $thumbnail = asset('/img/profile.png');
    if ($image && !empty($image) && file_exists(public_path('uploads/riders/' . @$image))) {
        $thumbnail = asset('/uploads/riders/' . @$image);
    }
    return $thumbnail;
}

// string date to readable dates format
function ReadableDate($date, $type = null)
{
    if ($date) {
        $date = strtotime($date);
        if ($type == 'all') {
            return date('F d, Y h:i a', $date);
        } else if ($type == 'y') {
            return date('Y', $date);
        } else if ($type == 'ym') {
            return date('F Y', $date);
        } else if ($type == 'ymd') {
            return date('F d, Y', $date);
        } else if ($type == 'mf') {
            return date('F  h:i a', $date);
        } else if ($type == 'md') {
            return date('F d', $date);
        } else if ($type == 'fdt') {
            return date('F d, h:i a', $date);
        } else if ($type == 'dt') {
            return date('d, h:i a', $date);
        } else if ('time') {
            return date('h:i a', $date);
        }
    } else {
        return '';
    }
}

//for list of slider type
define('SLIDER_TYPE', [
    'trending' => 'Trending',
    'offer' => 'Offer',
]);

define('SHOW_ON', [
    'header_menu' => 'Header Menu',
    'footer_menu' => 'Footer Menu',
    // 'footer_menu' => '',
]);
/*
 * Map pagination data for api response while returning data
 *
 * @return
 */
function mapPageItems($data, $key = null)
{
    $mapdata = [
        'current_page' => $data->currentpage(),
        'total' => $data->total(),
        'perPage' => $data->perPage(),
        'lastPage' => $data->lastPage(),
    ];
    // dd($data->items());
    if ($key) {
        $mapdata[$key] = ($data->items() || count($data->items())) ? $data->items() : null;
    }
    return $mapdata;
}

//for list of content type
define('CONTENT_TYPE', [
    'category' => 'Category Page',
    'home' => 'Home',
    'about' => 'About',
    'contact' => 'Contact',
    'blogs' => 'Blogs',
    'basicpage' => 'Basic Page',
]);

//return valid url
function validate_url($url)
{
    return ((strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) && filter_var($url, FILTER_VALIDATE_URL) !== false);
}

function getYoutubeVideoId($url)
{
    $matches = null;
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    return $matches;
}

function getFacebookVideoId($url)
{
    $matches = null;
    preg_match("~/videos/(?:t\.\d+/)?(\d+)~i", $url, $matches);
    return $matches;
}

function isVerified($status = null)
{
    if (!$status || $status == '0' || $status == 0) {
        return 'Unverified';
    } else if ($status == 1 || $status == '1') {
        return 'Verified';
    }
}

function getDuration($starttimestamp, $endtimestamp)
{
    $start_time = strtotime($starttimestamp);
    $end_time = strtotime($endtimestamp);
    $duration = ($end_time - $start_time) / 1000;
    return $duration;
}
function getImageFromUrl($filepath)
{
    $image_url = explode('uploads/', $filepath);
    // dd($image_url);
    $path = explode('/', $image_url[1]);
    // dd($path);
    $image = end($path);

    $image_path = str_replace($image, '', $image_url[1]);
    return [
        'path' => $image_path,
        'image' => $image,
    ];
}
function getThumbImage($image, $path)
{
    $thumbnail = asset('/uploads/' . $path . 'thumbs/' . $image);
    return $thumbnail;
}
function getFullImage($image, $path)
{
    $thumbnail = asset('/uploads/' . $path . $image);
    return $thumbnail;
}
