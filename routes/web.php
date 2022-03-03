<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

######################## GUEST #####################################################################
//Index
Route::get('/',                                                         'IndexController@index')->name('index');
Route::get('/about-us',                                                 'AboutUsController@createAboutUs')->name('aboutus');


//Login
Route::get('/account/login',                                            'Auth\LoginController@createLogin')->name('login');
Route::post('/account/login',                                           'Auth\LoginController@attemptLogin')->name('login');
//Create New Account
//candidate
Route::get('/register/candidate',                                       'Auth\RegisterController@createRegistrationCandidate')->name('registerCandidate');
Route::post('/register/candidate',                                      'Auth\RegisterController@saveRegistrationCandidate')->name('postRegisterCandidate');
//employer
Route::get('/register/employer',                                        'Auth\RegisterController@createRegistrationEmployer')->name('registerEmployer');
Route::post('/register/employer',                                       'Auth\RegisterController@saveRegistrationEmployer')->name('postRegisterEmployer');
Route::get('/registration-completed',                                   'Auth\RegisterController@registrationCompleted')->name('registerCompleted');
//Logout
Route::get('/logout', 			                                        'Auth\LoginController@logout')->name('logout');
//Our Terms and Condition
Route::get('/term-and-condictions', 			                        'TermsAndConditionsController@createTermAndCondition')->name('readTermCondition');
//search for job
Route::get('/job/search/{cid?}',                                        'JobListingAndSearchController@createJobSearch')->name('searchJob');
Route::post('/job/search',                                              'JobListingAndSearchController@postJobSearch')->name('postSearchJob');
Route::get('/job/details/{jid?}',                                       'JobListingAndSearchController@getJobDetails')->name('searchJobDetails');



######################## END GUEST ####################################################################


//THIS CHECK STRICTLY USER AUTH ONLY
######################## ONLY AUTH USER ##############################################################
Route::group(['/middleware' => ['auth'], 'middleware' => ['clear-history'], 'middleware' => ['GoToHttps']], function ()
{
    //Dashboard: Both Candidate and Employer
    Route::get('/dashboard',                                            'DashboardController@dashboard')->name('dashboard');

});

//THIS CHECK STRICTLY USER ROLE AND USER AUTH ONLY
Route::group(['/middleware' => ['auth'], 'middleware' => ['clear-history'], 'middleware' => ['GoToHttps'], 'middleware' => ['checkRoleRoute']], function ()
{
    //chnage password
    Route::get('/account/security',                                     'ChangePasswordController@createChangePassword')->name('changePassword');
    Route::post('/account/security',                                    'ChangePasswordController@saveUpdatePasswordOnAuth')->name('postChangePassword');
    //######### RESUME
    //Cover letter
    Route::get('/resume',                                            'ResumeController@createResume')->name('createResume');
    Route::post('/update-cover-letter',                                 'ResumeController@updateCoverLetter')->name('postCoverLetter');
    Route::get('/update-cover-letter',                                 'ResumeController@createResume');
    //education
    Route::post('/add-education',                                       'ResumeController@addNewEducation')->name('postAddEducation');
    Route::get('/add-education',                                        'ResumeController@createResume');
    Route::post('/education/save-changes',                              'ResumeController@educationSaveChanges')->name('postEducationSaveChanges');
    Route::get('/education/save-changes',                              'ResumeController@createResume');
    Route::get('/education/remove/{eid?}',                              'ResumeController@deleteEducation')->name('deleteEducation');
    //work & experience
    Route::post('/add-work-experience',                                 'ResumeController@addNewWorkExperience')->name('postWorExperience');
    Route::get('/add-work-experience',                                 'ResumeController@createResume');
    Route::post('/work-experience/save-changes',                        'ResumeController@workExperienceSaveChanges')->name('postWorkExperienceSaveChanges');
    Route::get('/work-experience/save-changes',                        'ResumeController@createResume');
    Route::get('/work-experience/remove/{weid?}',                       'ResumeController@deleteWorkExperience')->name('deleteWorkExperience');
    //professional skill
    Route::post('/add-professional-skill',                              'ResumeController@addNewSkill')->name('postSkill');
    Route::get('/add-professional-skill',                              'ResumeController@createResume');
    Route::post('/profession-skill/save-changes',                       'ResumeController@skillSaveChanges')->name('postSkillSaveChanges');
    Route::get('/profession-skill/save-changes',                       'ResumeController@createResume');
    Route::get('/skill/remove/{psid?}',                                 'ResumeController@deleteSkill')->name('deleteSkill');
     //Upload CV
     Route::post('/add-cv',                                             'ResumeController@uploadCv')->name('postUploadCv');
     Route::get('/add-cv',                                             'ResumeController@createResume');
     Route::get('/cv/remove/{cvid?}',                                   'ResumeController@deleteCv')->name('deleteCv');
    //View Resume Details
    Route::get('/view-resume',                                            'ResumeController@viewResumeDetails')->name('viewMyResume');

    //Job Applied for
    Route::get('/applied-job',                                           'ManageAppliedJobController@createManageJob')->name('createManageJob');
    //saved Job
    Route::get('/saved-jobs',                                           'SavedJobsController@createSavedJobs')->name('createSavedJob');
    //Profile Candidate
    Route::get('/candidate/profile',                                    'ProfileController@createCandidateProfile')->name('candidateProfile');
    Route::post('/candidate/profile',                                   'ProfileController@saveChangesCandidateBasicInformation')->name('saveChangesBasicInfoCandiate');
    //profile image and cover images
    Route::get('/user/profile-photo',                                   'ProfileController@createProfilePhotoAndCoverImage')->name('createProfileImage');
    Route::post('/user/profile-photo',                                  'ProfileController@saveProfilePhotoAndCoverImage')->name('postProfileImage');
     //Profile Employer Profile
     Route::get('/employer/profile',                                    'ProfileController@createEmployerProfile')->name('employerProfile');
     Route::post('/employer/profile',                                   'ProfileController@saveChangesEmployerBasicInformation')->name('saveChangesBasicInfoEmployer');

    //Dashboard: Employer
    Route::get('/employer/post-job',                                    'PostJobController@createNewPostJob')->name('createPostJob');
    Route::post('/employer/post-job',                                   'PostJobController@saveNewPostJob')->name('saveNewJob');
    Route::get('/job-details/{jid?}',                                   'PostJobController@createJobDetails')->name('viewJobDetails');
    //Employer - Manage Job
    Route::get('/employer/manage-job',                                  'PostJobController@createManageJob')->name('createEmployerManageJob');
    //Admin - Manage Job
    Route::get('/admin/manage-job',                                     'PostJobController@createManageJobAdmin')->name('AdminManageJob');
    //Delete Posted Job
    Route::get('/job/delete/{jid?}',                                    'PostJobController@deletePostedJob')->name('deleteJob');
    Route::get('/job/update/{jid?}',                                    'PostJobController@editPostedJob')->name('editJob');
    Route::get('/job/cancel-edit',                                      'PostJobController@cancelEditPostedJob')->name('cancelEditing');
    //Employer Manage Candidate
    Route::get('/manage-candidate/{jid?}',                              'ManageCandidateApplicationController@createManageCandidateApplication')->name('manageCandidate');
    Route::get('/get-job-and-candidate/{jid?}',                         'ManageCandidateApplicationController@setSessionForJobAndCandidate');
    Route::get('/update-candidate-status/{jid?}/{jaid?}/{s?}',          'ManageCandidateApplicationController@updateCandidateStatus')->name('updateCandidateStatus');
    Route::get('/candidate/view-status/{jid?}/{s?}',                    'ManageCandidateApplicationController@candidateAppliedForJobWithStatus')->name('viewCandidateAppliedForJob');
    //Apply for job
    Route::post('/job/details/',                                        'JobListingAndSearchController@applyForJob')->name('postApplyForJob');

    //Build CV
    Route::get('/build-cv',                                             'BuildCVController@createBuildCV')->name('createBuildCV');
    Route::get('/request/build-cv',                                     'BuildCVController@createRequestBuildCV')->name('requestBuildCV');
    Route::post('/request/build-cv',                                    'BuildCVController@saveRequestBuildCV')->name('postRequestBuildCV');
    Route::get('/list/build-cv',                                        'BuildCVController@listAllRequestForBuildCV')->name('listCVBuildRequest');

    //Admin: View list of request for CVBuilding
    Route::get('/build-cv-requst',                                      'AdminSetupController@viewAllBuildCVRequest')->name('viewCVBuildRequest');
    Route::post('/build-cv-requst',                                      'AdminSetupController@uploadNewCv')->name('postNewCVRequest');
    //View list of all registered user
    Route::get('/user/registered/',                                     'AdminSetupController@viewAllRegisteredUser')->name('viewRegisteredUsers');
    //Wallet
    Route::get('/wallet',                                               'WalletController@creatWallet')->name('wallet');
    Route::post('/wallet',                                              'WalletController@storeWallet')->name('postFundWallet');
    Route::get('/wallet/transaction',                                   'WalletController@viewPaymentHistory')->name('walletTransaction');
    Route::get('/wallet/statement-account/{from?}/{to?}',               'WalletController@viewWalletStatementAccount')->name('walletStatmentAccount');
    Route::post('/wallet/statement-account',                            'WalletController@postWalletStatementAccount')->name('postWalletStatmentAccount');
    //Admin - view wallet payment transaction
    Route::get('/wallet/all-history/{from?}/{to?}/{uid?}',              'AdminSetupController@viewAllWalletPaymentTransaction')->name('viewAllWalletTransaction');
    Route::post('/wallet/all-history',                                  'AdminSetupController@postWalletPaymentTransaction')->name('postAllWalletTransaction');





    // Laravel 5.1.17 and above
    ##################### Payment Start #############################
    Route::get('/pay/how-to-pay/{phID?}',                               'PaymentController@createHowToPay')->name('whereToMakePayement');
    Route::get('/pay/{phID?}/{pay?}',                                   'PaymentController@createPaymentSummary')->name('getPaymentSummary');
    Route::post('/pay',                                                 'PaymentController@makePayment')->name('payNow');

});
//Make Payment
//Route::get('payment/callback', ['uses' => 'PayStackPaymentController@handleGatewayCallback']);
Route::get('/payment/callback',                                         'PayStackPaymentController@handleGatewayCallback');
Route::get('/payment-completed',                                        'PayStackPaymentController@createPaymentComplete')->name('paymentCompleted');
Route::get('/payment-not-complete',                                     'PayStackPaymentController@createPaymentNotComplete')->name('paymentNotCompleted');
######################## END AUTH USER ################################################################

















/////////////////////////////////////////ROLE AND PERMISSION/////////////////////////////////////////////
Route::group(['/middleware' => ['auth'], 'middleware' => ['clear-history'], 'middleware' => ['checkRoleRoute']], function ()
{
    //Module and SubModule Set up
    Route::get('/create-route-module',                            'ModuleController@createRouteModule')->name('createModule');
    Route::post('/create-route-module',                           'ModuleController@saveModule')->name('addModule');
    Route::get('/remove/module/{id?}',                            'ModuleController@removeModule')->name('removeModule');
    Route::get('/edit/module/{id?}',                              'ModuleController@editModule')->name('editModule');
    Route::get('/cancel-module-editing',                          'ModuleController@cancelEditModule')->name('cancelEditModule');
    //SubModule and SubModule Set up
    Route::get('/create-route-submodule',                         'SubModuleController@createRouteSubModule')->name('createSubModule');
    Route::post('/create-route-submodule',                        'SubModuleController@saveSubModule')->name('addSubModule');
    Route::get('/remove/submodule/{id?}',                         'SubModuleController@removeSubModule')->name('removeSubModule');
    Route::get('/edit/submodule/{id?}',                           'SubModuleController@editSubModule')->name('editSubModule');
    Route::get('/cancel-submodule-editing',                       'SubModuleController@cancelEditSubModule')->name('cancelEditSubModule');
    //Role and Permission
    Route::get('/create-update-role',                             'RolePermissionController@createRole')->name('createRole');
    Route::post('/create-update-role',                            'RolePermissionController@saveRole')->name('saveRole');
    Route::get('/remove-role/{id?}',                              'RolePermissionController@removeRole')->name('removeRole');
    Route::get('/edit-role/{id?}',                                'RolePermissionController@editRole')->name('editRole');
    Route::get('/cancel-role-editing',                            'RolePermissionController@cancelEditRole')->name('cancelEditRole');
    Route::get('/assigning-submodule-to-role',                    'RolePermissionController@createSubmoduleToRole')->name('createSubmoduleAssignment');
    Route::post('/assigning-submodule-to-role',                   'RolePermissionController@saveSubmoduleToRole')->name('postSubmoduleAssignment');
    Route::get('/assigning-role-to-user',                         'RolePermissionController@createRole');
    Route::post('/assigning-role-to-user',                        'RolePermissionController@assignRoleToUser')->name('assignRoleToUser');
});
/////////////////////////////////////////ROLE AND PERMISSION/////////////////////////////////////////////

/* $path = $getFullPath . $getFile;
                    chown($path, 666);
                    if (unlink($path)) {
                        $data['message'] = 'Unlink was successful.';
                        $data['status']  = 1;
                    } else {
                        $data['status']  = 0;
                    } */

                    //<a href="{{ redirect()->getUrlGenerator()->previous()  }}"> Go Back </a>
