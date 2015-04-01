<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
// 
// Patterns
Route::pattern('id', '[0-9]+');

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getIndex'])->before('guest');
Route::get('gallery', ['as' => 'gallery', 'uses' => 'GalleryController@getIndex']);
Route::get('image/{id}/{slug?}', ['as' => 'image', 'uses' => 'ImageController@getIndex']);
Route::get('user/{username}', ['as' => 'user', 'uses' => 'UserController@getUser']);
Route::get('user/{username}/favorites', ['as' => 'users.favorites', 'uses' => 'UserController@getFavorites']);
Route::get('user/{username}/followers', ['as' => 'users.followers', 'uses' => 'UserController@getFollowers']);
Route::get('user/{username}/rss', ['as' => 'users.rss', 'uses' => 'UserController@getRss']);
Route::get('users', ['as' => 'users', 'uses' => 'UserController@getAll']);
Route::get('category/{category}', ['as' => 'category', 'uses' => 'CategoryController@getIndex']);
Route::get('category/{category}/rss', 'CategoryController@getRss');
Route::get('tag/{tag}', ['as' => 'tag', 'uses' => 'TagsController@getIndex']);
Route::get('tag/{tag}/rss', 'TagsController@getRss');
Route::get('notifications', ['as' => 'notifications', 'uses' => 'UserController@getNotifications']);
Route::get('search', ['as' => 'search', 'uses' => 'ImageController@search']);
Route::get('tos', ['as' => 'tos', 'uses' => 'PolicyController@getTos']);
Route::get('privacy', ['as' => 'privacy', 'uses' => 'PolicyController@getPrivacy']);
Route::get('faq', ['as' => 'faq', 'uses' => 'PolicyController@getFaq']);
Route::get('about', ['as' => 'about', 'uses' => 'PolicyController@getAbout']);
Route::get('featured', ['as' => 'images.featured', 'uses' => 'GalleryController@featured']);
Route::get('popular', ['as' => 'images.popular', 'uses' => 'GalleryController@mostPopular']);
Route::get('most/viewed', ['as' => 'images.most.viewed', 'uses' => 'GalleryController@mostViewed']);
Route::get('most/commented', ['as' => 'images.most.commented', 'uses' => 'GalleryController@mostCommented']);
Route::get('most/favorites', ['as' => 'images.most.favorites', 'uses' => 'GalleryController@mostFavorited']);
Route::get('most/downloads', ['as' => 'images.most.downloads', 'uses' => 'GalleryController@mostDownloaded']);
Route::get('blogs', ['as' => 'blogs', 'uses' => 'BlogsController@getIndex']);
Route::get('blog/{id}/{slug}', ['as' => 'blog', 'uses' => 'BlogsController@getBlog']);
Route::get('lang/{lang?}', function ($lang)
{
    if (in_array($lang, languageArray()))
    {
        Session::put('my.locale', $lang);
    }
    else
    {
        Session::put('my.locale', 'en');
    }

    return Redirect::route('home');
});
Route::post('queue/receive', function ()
{
    return Queue::marshal();
});

/**
 * Guest only visit this section
 */
Route::group(array('before' => 'guest'), function ()
{
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
    // Facebook
    Route::get('get/facebook', 'LoginController@loginWithFacebook');
    Route::get('registration/facebook', 'RegistrationController@getFacebook');
    // Google
    Route::get("get/google", 'LoginController@loginWithGoogle');
    Route::get("registration/google", 'RegistrationController@getGoogle');

    Route::controller('password', 'RemindersController');
    Route::get('registration', ['as' => 'registration', 'uses' => 'RegistrationController@getIndex']);
    Route::get('registration/activate/{username}/{code}', 'RegistrationController@validateUser');
});

/**
 * Guest Post form with csrf protection
 */
Route::group(array('before' => 'csrf|guest'), function ()
{
    Route::post('login', 'LoginController@postLogin');
    // Facebook
    Route::post('registration/facebook', 'RegistrationController@postFacebook');
    // Google
    Route::post('registration/google', 'RegistrationController@postGoogle');
    // Normal Registration
    Route::post('registration', 'RegistrationController@postIndex');
    Route::post('password/remind', ['as' => 'password.reminder', 'uses' => 'PasswordresetController@postIndex']);
    Route::post('password/reset/{token}', 'PasswordresetController@resetPassword');
});


/*
 * Ajax post
 */
Route::group(array('before' => 'ajax|ajaxban'), function ()
{
    Route::post('favorite', 'ImageController@postFavorite');
    Route::post('follow', 'UserController@follow');
    Route::post('reply', 'ReplyController@postReply');
    Route::post('deletecomment', 'CommentController@postDeleteComment');
    Route::post('deletereply', 'ReplyController@postDeleteReply');
    Route::post('upload', 'UploadController@postUpload')->before('ban');
});

/*
 * Require login to access these sections
 */
Route::group(array('before' => 'auth'), function ()
{
    Route::get('image/{id}/{slug?}/edit', ['as' => 'images.edit', 'uses' => 'ImageController@getEdit'])->where(array('id' => '\d+'));
    Route::get('upload', ['as' => 'images.upload', 'uses' => 'UploadController@getIndex'])->before('ban');
    Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);
    Route::get('feeds', ['as' => 'users.feeds', 'uses' => 'UserController@getFeeds']);
    Route::get('user/{username}/following', ['as' => 'users.following', 'uses' => 'UserController@getFollowing']);
    Route::get('image/{any}/download', ['as' => 'images.download', 'uses' => 'ImageController@download'])->before('ban');
    Route::get('settings', ['as' => 'users.settings', 'uses' => 'UserController@getSettings']);
    Route::get('image/{id}/{slug?}/delete', ['as' => 'images.delete', 'uses' => 'ImageController@delete']);
    Route::get('image/{id}/{slug?}/report', ['as' => 'images.report', 'uses' => 'ReportController@getReport'])->before('ban');
    Route::get('user/{username}/report', ['as' => 'user.report', 'uses' => 'ReportController@getReport'])->before('ban');
});

/**
 * Post Sections CSRF + AUTH both
 */
Route::group(array('before' => 'csrf|auth'), function ()
{

    Route::post('image/{id}/{slug?}', 'CommentController@postComment')->where(array('id' => '\d+'))->before('ban');
    Route::post('image/{id}/{slug?}/edit', 'ImageController@postEdit')->where(array('id' => '\d+'))->before('ban');
    Route::post('settings/changepassword', 'UserController@postChangePassword');
    Route::post('settings/updateprofile', 'UserController@postUpdateProfile');
    Route::post('settings/mailsettings', 'UserController@postMailSettings');
    Route::post('settings/updateavatar', 'UserController@postUpdateAvatar');
    Route::post('image/{id}/{slug?}/report', 'ReportController@postReportImage')->before('ban');
    Route::post('user/{username}/report', 'ReportController@postReportUser')->before('ban');

});


/**
 * Admin section users with admin privileges can access this area
 */
Route::group(array('before' => 'admin', 'namespace' => 'Controllers\Admin'), function ()
{
    Route::get('admin', 'IndexController@getIndex');
// Users Manager
    Route::get('admin/users', 'Users\UsersController@getUsersList');
    Route::get('admin/users/featured', 'Users\UsersController@getFeaturedUserList');
    Route::get('admin/users/banned', 'Users\UsersController@getBannedUserList');
    Route::get('admin/user/{username}/edit', 'Users\UsersController@getEditUser');
    Route::get('admin/adduser', 'Users\UsersController@getAddUser');
    Route::post('admin/user/{username}/edit', 'Users\UpdateController@updateUser');
    Route::post('admin/adduser', 'Users\UpdateController@addUser');

// Image Manger
    Route::get('admin/images', 'Images\ImageController@getImagesList');
    Route::get('admin/images/featured', 'Images\ImageController@featuredImagesList');
    Route::get('admin/images/approval', 'Images\ImageController@getImagesApproval');
    Route::get('admin/image/{id}/edit', 'Images\ImageController@getEdit');
    Route::post('admin/image/{id}/edit', 'Images\UpdateController@postEdit');
    Route::post('admin/images/approve', 'Images\UpdateController@postApprove');
    Route::post('admin/images/disapprove', 'Images\UpdateController@postDisapprove');

// Site Settings
    Route::get('admin/sitesettings', 'SiteSettings\SettingsController@getSiteDetails');
    Route::get('admin/sitecategory', 'SiteSettings\SettingsController@getSiteCategory');
    Route::get('admin/limitsettings', 'SiteSettings\SettingsController@getLimitSettings');
    Route::get('admin/removecache', 'SiteSettings\SettingsController@getRemoveCache');
    Route::get('admin/updatesitemap', 'SiteSettings\UpdateController@updateSiteMap');
    Route::get('admin/clearcache', 'SiteSettings\UpdateController@clearCache');
    Route::post('admin/sitesettings', 'SiteSettings\UpdateController@updateSettings');
    Route::post('admin/limitsettings', 'SiteSettings\UpdateController@postLimitSettings');
    Route::post('admin/sitecategory', 'SiteSettings\UpdateController@createSiteCategory');
    Route::post('admin/sitecategory/reorder', 'SiteSettings\UpdateController@reorderSiteCategory');
    Route::post('admin/sitecategory/update', 'SiteSettings\UpdateController@updateSiteCategory');
// Comments
    Route::get('admin/comments', 'Comments\CommentsController@getComments');
    Route::get('admin/comment/{id}/edit', 'Comments\CommentsController@getEditComment');
    Route::post('admin/comment/{id}/edit', 'Comments\CommentsController@postEditComment');


// Blogs
    Route::get('admin/blogs', 'Blogs\BlogsController@getBlogs');
    Route::get('admin/blog/create', 'Blogs\BlogsController@getCreate');
    Route::get('admin/blog/{id}/edit', 'Blogs\BlogsController@getEdit');
    Route::post('admin/blog/create', 'Blogs\BlogsController@postCreate');
    Route::post('admin/blog/{id}/edit', 'Blogs\BlogsController@postEdit');

//Bulk upload
    Route::get('admin/bulkupload', 'Bulkupload\BulkuploadController@getBulkUpload');
    Route::post('admin/bulkupload', 'Bulkupload\BulkuploadController@postBulkUpload');

// Reports
    Route::get('admin/reports', 'Reports\ReportsController@getReports');
    Route::get('admin/report/{id}', 'Reports\ReportsController@getReadReport');

});