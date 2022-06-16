<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

function access($name = '')
{
    $arrURL = explode('/', \Request::url());//GET URL
    $modul = !empty($arrURL[3]) ? $arrURL[3] : ''; //GET MODUL
    $menu = !empty($arrURL[4]) ? explode('?', $arrURL[4])[0] ?? '' : ''; //GET MENU WITHOUT PARAM

    $access = DB::table('app_user_accesses')
        ->select('app_user_accesses.name', 'app_user_accesses.id')
        ->join('app_menus', function ($join) use ($menu) {
            $join->on('app_user_accesses.menu_id', 'app_menus.id');
            $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
            $join->where('app_menus.target', $menu);
        })
        ->join('app_moduls', function ($join) use ($modul, $name) {
            $join->on('app_menus.modul_id', 'app_moduls.id');
            $join->where('app_moduls.target', $modul);
            $join->where('app_user_accesses.name', $name);
        })->pluck('name', 'id')->toArray();//JOIN TO GET ACCESS

    return $access;
}

function setCurrency($value)
{
    return number_format($value);
}

function resetCurrency($value)
{
    list($value) = explode("]", str_replace("[>", "", $value));
    $value = $value == "" ? "0" : $value;

    $ret = substr($value, 0, 1) == "." ? "0" . $value : $value;
    $ret = str_replace(",", "", $ret);

    return $ret;
}

function setDate($value, $format = null)
{
    return Carbon::createFromFormat('Y-m-d', $value)->format($format ? 'd F Y' : 'd/m/Y');
}

function resetDate($value)
{
    return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
}

function defaultStatus()
{
    return array('t' => 'Aktif', 'f' => 'Tidak Aktif');
}

function yesOrNoOption()
{
    return array('t' => 'Ya', 'f' => 'Tidak');
}

function defaultStatusApproval()
{
    return array('t' => 'Disetujui', 'f' => 'Ditolak');
}

function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
{
    $name = !is_null($filename) ? $filename : Str::random(25);

    $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

    return $file;
}

function uploadFile($image, $name, $folder)
{
    if($image){
        // Make a file path where image will be stored [ folder path + file name + file extension]
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        // Upload image
        uploadOne($image, $folder, 'public', $name);
        // Set user profile image path in database to filePath
        $picture = $filePath;

        return $picture;

    }
}

function generatePagination($items, $form = 'form')
{
    $pagination = $items->withQueryString()->links();
    $arrNumber = array("10", "50", "100", "500");
    ?>
    <div class="d-flex justify-content-between align-items-center">
        <div class="ml-1">
            <select name="paginate" form="<?= $form ?>" onchange="document.getElementById('form').submit();" class="custom-select form-control">
                <?php
                foreach ($arrNumber as $key => $value)
                {
                    $selected = 10;
                    if(!empty($_GET['paginate']))
                        $selected = $_GET['paginate'] == $value ? 'selected' : '';
                echo "<option $selected value=\"$value\">$value</option>";
                }
                ?>
            </select>
        </div>
        <div class="ml-1 <?= $items->total() <= $items->perPage() ? 'mb-1' : '' ?>">
            <i style="font-size: 12px">Showing <?= $items->firstItem() ?> to <?= $items->lastItem() ?> of <?= $items->total() ?> entries</i>
        </div>
        <div>
            <?php
            if($items->total() >= $items->perPage()) {
                echo $pagination;
            }else{
                ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end mt-1 mr-2 mb-2">
                        <li class="page-item prev"><a class="page-link"></a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link">1</a>
                        </li>
                        <li class="page-item next"><a class="page-link"></a></li>
                    </ul>
                </nav>
            <?php
            }
            ?>
        </div>

    </div>
    <br>
<?php
}

function numToRoman($number)
{
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function numToMonth($number)
{
    \Carbon\Carbon::setLocale('id');
    $date = \Carbon\Carbon::parse('2021-'.$number.'-01');
    $monthName = $date->translatedFormat('F');

    return $monthName;
}

function numToAlpha($number) {
    $numeric = $number % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($number / 26);
    if ($num2 > 0) {
        return numToAlpha($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

function getStatusApproval($value)
{
    if($value == 't') {
        $badge = 'success';
        $text = 'Approved';
    } else if($value == 'p') {
        $badge = 'info';
        $text = 'Pending';
    } else if($value == 'f'){
        $badge = 'danger';
        $text = 'Rejected';
    }else{
        $badge = 'secondary';
        $text = 'Need Action';
    }

    return "<div class='badge badge-$badge'>$text</div>";
}

function getIcon($value, $size = 'fa-2x')
{
    $extension = pathinfo(strtolower($value), PATHINFO_EXTENSION);

    $arrImage = array(
        'doc' => 'word',
        'docx' => 'word',
        'pdf' => 'pdf',
        'xls' => 'excel',
        'xlsx' => 'excel',
        'csv' => 'csv',
        'jpg' => 'image',
        'jpeg' => 'image',
        'png' => 'image',
        'jfif' => 'image',
    );

    $image = $arrImage[$extension];

    $icon = "<i class=\"fas $size fa-file-$image\"></i>";

    return $icon;
}

?>
