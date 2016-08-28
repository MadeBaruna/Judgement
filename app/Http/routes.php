<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@index')->name('index');;

Route::auth();

Route::get('contest/{id}', 'Contest\ContestController@index');
Route::get('contest/{id}/scoreboard', 'Contest\ContestController@scoreboard');
Route::get('contest/{id}/submissions', 'Contest\ContestController@submissions');
Route::get('contest/{id}/submission/{sub}', 'Contest\ContestController@submissionView');
Route::get('contest/{id}/problem/{contest}', 'Contest\ContestController@problem');
Route::post('contest/{id}/problem/{contest}/submit', 'Contest\SubmissionController@submitPost');

//profile
Route::get('profile', 'Profile\ProfileController@profile');
Route::get('profile/edit', 'Profile\ProfileController@changeProfile');
Route::post('profile', 'Profile\ProfilePictureUpload@upload');
Route::post('profile/confirm', 'Profile\ProfilePictureUpload@confirmation');
Route::post('profile/edit', 'Profile\ProfileController@edit');

Route::get('profile/groups', 'Profile\ProfileGroupController@groups');
//end profile

//admin dashboard
Route::get('admin', function () {
    return redirect('/admin/contests');
});
Route::get('admin/contests', 'Admin\AdminContest@contests');
Route::get('admin/contest/{id}', 'Admin\AdminContest@contestSummary');

Route::get('admin/contests/new', 'Admin\AdminContest@newContest');
Route::post('admin/contests/new', 'Admin\AdminContest@newContestPost');

Route::get('admin/contests/edit/{id}', 'Admin\AdminContest@editContest');
Route::post('admin/contests/edit/{id}', 'Admin\AdminContest@editContestPost');
Route::post('admin/contests/delete/{id}', 'Admin\AdminContest@deleteContestPost');

Route::get('admin/contest/{id}/problems', 'Admin\AdminContestProblem@problems');
Route::post('admin/contest/{id}/problems/add', 'Admin\AdminContestProblem@addProblemPost');
Route::post('admin/contest/{id}/problems/delete', 'Admin\AdminContestProblem@deleteProblemPost');

Route::get('admin/problems', 'Admin\AdminProblem@problems');
Route::get('admin/problem/{id}', 'Admin\AdminProblem@problemSummary');

Route::get('admin/problems/new', 'Admin\AdminProblem@newProblem');
Route::post('admin/problems/new', 'Admin\AdminProblem@newProblemPost');

Route::get('admin/problems/edit/{id}', 'Admin\AdminProblem@editProblem');
Route::post('admin/problems/edit/{id}', 'Admin\AdminProblem@editProblemPost');
Route::post('admin/problems/delete/{id}', 'Admin\AdminProblem@deleteProblemPost');

Route::get('admin/problem/{id}/testcases', 'Admin\AdminTestcase@testcases');
Route::get('admin/problem/{id}/testcase/{testcase}', 'Admin\AdminTestcase@viewTestcase');
Route::post('admin/problem/{id}/testcases/delete', 'Admin\AdminTestcase@deleteTestCasePost');
Route::post('admin/problem/{id}/testcases', 'Admin\AdminTestcase@newTestcasePost');

Route::get('admin/scoreboard/{id}', 'Admin\AdminScoreboard@scoreboard');
//end admin dashboard

Route::get('time', 'Time@getCurrentTime');

Route::get('test/{id}', 'CompileController@compile');
