<?php
/**
 * @author Djordje Stojiljkovic <djordjewebdizajn@gmail.com>
 */

function siteSettings($request)
{
    $request = DB::table('sitesettings')->where('option', '=', $request)->remember(999, $request)->first();
    return $request->value;
}

/**
 * @return mixed
 */
function siteCategories()
{
    return Category::remember(999, 'categories')->orderBy('lft','asc')->get();

}

/**
 * Pagination limit per page in gallery
 * @param int $int
 * @return int
 */
function perPage($int = 20)
{
    if (!siteSettings('numberOfImagesInGallery')) {
        return 20;
    }
    return abs((int)siteSettings('numberOfImagesInGallery'));
}

/**
 * Number of tags that an image can hold
 * @param int $int
 * @return int
 */
function tagLimit($int = 5)
{
    return $int;
}

/**
 * @param int $int
 * @return int
 */
function limitPerDay($int = 100)
{
    if (siteSettings('limitPerDay') == '') {
        return $int;
    }
    return siteSettings('limitPerDay');
}