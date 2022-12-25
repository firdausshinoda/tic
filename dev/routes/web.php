<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\ApiAuthor;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiParticipanController;
use App\Http\Controllers\ApiReviewerController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ParticipanController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\SubController;
use App\Http\Controllers\TableController;
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

Route::get('/coba', [DashboardController::class, 'coba']);
//Route::get('/', [DashboardController::class, 'perbaikan']);
Route::get('/', [DashboardController::class, 'index']);
Route::get('/progress-report', [DashboardController::class, 'progress_report']);
Route::get('/contact-us', [DashboardController::class, 'contact_us']);
Route::get('/committee', [DashboardController::class, 'committee']);
Route::get('/faq', [DashboardController::class, 'faq']);
Route::get('/registration', [DashboardController::class, 'registration']);
Route::get('/login', [DashboardController::class, 'login']);
Route::get('/payment', [DashboardController::class, 'payment']);
Route::get('/download_dashboard', [DashboardController::class, 'download']);
Route::get('/forgot', [SubController::class, 'forgot']);

Route::get('/sub/{slug}', [SubController::class, 'index']);
Route::get('/sub/{slug}/committee', [SubController::class, 'committee']);
Route::get('/sub/{slug}/list-users', [SubController::class, 'list_users']);
Route::get('/sub/{slug}/list-abstract', [SubController::class, 'list_abstract']);
Route::get('/sub/{slug}/list-videos', [SubController::class, 'list_videos']);
Route::get('/sub/{slug}/statistics-users', [SubController::class, 'statistics_users']);
Route::get('/sub/{slug}/statistics-abstract', [SubController::class, 'statistics_abstrak']);
Route::get('/sub/{slug}/qa-forum', [SubController::class, 'qa_forum']);
Route::get('/sub/{slug}/qa-forum/{no_abstract}', [SubController::class, 'qa_forum_detail']);
Route::get('/sub/{slug}/qa-forum/{no_abstract}/{id}', [SubController::class, 'qa_forum_detail']);
Route::get('/sub/{slug}/profile/{no_author}', [SubController::class, 'profile']);
Route::get('/sub/{slug}/abstract/{no_abstract}', [SubController::class, 'abstract']);
Route::get('/sub/{slug}/login', [SubController::class, 'login']);
Route::get('/sub/{slug}/forgot', [SubController::class, 'forgot']);
Route::get('/sub/{slug}/registration', [SubController::class, 'registration']);
Route::get('/sub/{slug}/payment', [SubController::class, 'payment']);
Route::get('/sub/{slug}/download', [SubController::class, 'download']);
Route::get('/sistem', [SubController::class, 'login_admin']);

Route::post('/api/jsonRegistrasi', [ApiAdminController::class, 'jsonRegistrasi']);
Route::post('/api/jsonLogin', [ApiAdminController::class, 'jsonLogin']);
Route::post('/api/jsonLoginAdmin', [ApiAdminController::class, 'jsonLoginAdmin']);

//--------------------------------------------API
Route::get('/api/dtTableProgressReport', [TableController::class, 'dtTableProgressReport']);

Route::get('/api/dtTableNotifParticipan', [TableController::class, 'dtTableNotifParticipan']);
Route::get('/api/dtTableNotifReviewer', [TableController::class, 'dtTableNotifReviewer']);
Route::get('/api/dtTableMyQuestionReviewer', [TableController::class, 'dtTableMyQuestionReviewer']);
Route::get('/api/dtTableNotifAuthor', [TableController::class, 'dtTableNotifAuthor']);
Route::get('/api/dtTableMyJournal', [TableController::class, 'dtTableMyJournal']);
Route::get('/api/dtTableMyJurnalQuestion', [TableController::class, 'dtTableMyJurnalQuestion']);
Route::get('/api/dtTableJournalRevision', [TableController::class, 'dtTableJournalRevision']);
Route::get('/api/dtTableMyQuestionAuthor', [TableController::class, 'dtTableMyQuestionAuthor']);
Route::get('/api/dtTableQAForum', [TableController::class, 'dtTableQAForum']);
Route::get('/api/dtTableRevision', [TableController::class, 'dtTableRevision']);
Route::get('/api/dtTableRevisionAuthorDetail', [TableController::class, 'dtTableRevisionAuthorDetail']);
Route::get('/api/dtTableRevisionDetail', [TableController::class, 'dtTableRevisionDetail']);
Route::get('/api/dtTableMyReviewReviewer', [TableController::class, 'dtTableMyReviewReviewer']);
Route::get('/api/dtTableNotifAdmin', [TableController::class, 'dtTableNotifAdmin']);
Route::get('/api/dtTableJournalConfirm', [TableController::class, 'dtTableJournalConfirm']);
Route::get('/api/dtTableJournalProcess', [TableController::class, 'dtTableJournalProcess']);
Route::get('/api/dtTableJournalDraft', [TableController::class, 'dtTableJournalDraft']);
Route::get('/api/dtTablePaymentJournal', [TableController::class, 'dtTablePaymentJournal']);
Route::get('/api/dtTablePaymentParticipan', [TableController::class, 'dtTablePaymentParticipan']);
Route::get('/api/dtTableAuthors', [TableController::class, 'dtTableAuthors']);
Route::get('/api/dtTableReviewers', [TableController::class, 'dtTableReviewers']);
Route::get('/api/dtTableParticipan', [TableController::class, 'dtTableParticipan']);
Route::get('/api/dtTableCountry', [TableController::class, 'dtTableCountry']);
Route::get('/api/dtTableDegree', [TableController::class, 'dtTableDegree']);
Route::get('/api/dtTableSosmed', [TableController::class, 'dtTableSosmed']);
Route::get('/api/dtTableContact', [TableController::class, 'dtTableContact']);
Route::get('/api/dtTableEvents', [TableController::class, 'dtTableEvents']);
Route::get('/api/dtTableCoHost', [TableController::class, 'dtTableCoHost']);
Route::get('/api/dtTableIndexing', [TableController::class, 'dtTableIndexing']);
Route::get('/api/dtTableTypePayment', [TableController::class, 'dtTableTypePayment']);
Route::get('/api/dtTableCollaboration', [TableController::class, 'dtTableCollaboration']);
Route::get('/api/dtTableKeynoteSpeaker', [TableController::class, 'dtTableKeynoteSpeaker']);
Route::get('/api/dtTableInvitedSpeaker', [TableController::class, 'dtTableInvitedSpeaker']);
Route::get('/api/dtTableSetting', [TableController::class, 'dtTableSetting']);
Route::get('/api/dtTableSub', [TableController::class, 'dtTableSub']);
Route::get('/api/dtTableScope', [TableController::class, 'dtTableScope']);
Route::get('/api/dtTableVC', [TableController::class, 'dtTableVC']);
Route::get('/api/dtTableTimeline', [TableController::class, 'dtTableTimeline']);
Route::get('/api/dtTableAbstract', [TableController::class, 'dtTableAbstract']);

Route::post('/api/ckAccountAuthor', [ApiController::class, 'ckAccountAuthor']);
Route::post('/api/submitForgotAuthor', [ApiController::class, 'submitForgotAuthor']);
Route::post('/api/submitForgotAuthor', [ApiController::class, 'submitForgotAuthor']);
Route::post('/api/selectNegara', [ApiController::class, 'selectNegara']);
Route::get('/api/journal', [ApiController::class, 'journal']);
Route::get('/api/getVideo', [ApiController::class, 'getVideo']);
Route::get('/api/getForum', [ApiController::class, 'getForum']);
Route::get('/api/detailJournal', [ApiController::class, 'detailJournal']);
Route::get('/api/getJournalQAForum', [ApiController::class, 'getJournalQAForum']);
Route::post('/api/insertQAForum', [ApiController::class, 'insertQAForum']);
Route::get('/api/detailQAForum', [ApiController::class, 'detailQAForum']);
Route::post('/api/detailTypePayment', [ApiController::class, 'detailTypePayment']);
Route::post('/api/updateMyJournalPaymentAdmin', [ApiController::class, 'updateMyJournalPaymentAdmin']);
Route::post('/api/insertQAForumSub', [ApiController::class, 'insertQAForumSub']);
Route::get('/download', [ApiController::class, 'download']);
Route::get('/download_loa', [ApiController::class, 'download_loa']);
Route::get('/download_loi', [ApiController::class, 'download_loi']);
Route::get('/download_payment_receipt', [ApiController::class, 'download_payment_receipt']);
Route::post('/api/deleteData', [ApiController::class, 'deleteData']);
Route::post('/api/updateJournalConfirmation', [ApiController::class, 'updateJournalConfirmation']);

Route::get('/api/getNotifAuthor', [ApiAuthor::class, 'getNotifAuthor']);
Route::post('/api/updateNotifAuthor', [ApiAuthor::class, 'updateNotifAuthor']);
Route::post('/api/insertMyJournal', [ApiAuthor::class, 'insertMyJournal']);
Route::get('/api/detailMyJournal', [ApiAuthor::class, 'detailMyJournal']);
Route::post('/api/updateMyJournal', [ApiAuthor::class, 'updateMyJournal']);
Route::post('/api/updateMyJournalPaperUpload', [ApiAuthor::class, 'updateMyJournalPaperUpload']);
Route::post('/api/updateMyJournalMetadata', [ApiAuthor::class, 'updateMyJournalMetadata']);
Route::post('/api/updateMyJournalPayment', [ApiAuthor::class, 'updateMyJournalPayment']);
Route::post('/api/updateMyJournalVideo', [ApiAuthor::class, 'updateMyJournalVideo']);
Route::get('/api/getTypePayment', [ApiAuthor::class, 'getTypePayment']);
Route::post('/api/updateRevisionAuthor', [ApiAuthor::class, 'updateRevisionAuthor']);
Route::get('/api/getAccountAuthor', [ApiAuthor::class, 'getAccountAuthor']);
Route::post('/api/updateAccountAuthor', [ApiAuthor::class, 'updateAccountAuthor']);
Route::post('/api/updateAccountAuthorPhoto', [ApiAuthor::class, 'updateAccountAuthorPhoto']);
Route::post('/api/updateAccountAuthorPassword', [ApiAuthor::class, 'updateAccountAuthorPassword']);

Route::get('/api/getNotifReviewer', [ApiReviewerController::class, 'getNotifReviewer']);
Route::post('/api/updateNotifReviewer', [ApiReviewerController::class, 'updateNotifReviewer']);
Route::post('/api/updateRevisionAdd', [ApiReviewerController::class, 'updateRevisionAdd']);
Route::post('/api/inputMyRevision', [ApiReviewerController::class, 'inputMyRevision']);
Route::post('/api/updateMyRevisionAcc', [ApiReviewerController::class, 'updateMyRevisionAcc']);
Route::post('/api/updateAccountReviewer', [ApiReviewerController::class, 'updateAccountReviewer']);
Route::post('/api/updateAccountReviewerPhoto', [ApiReviewerController::class, 'updateAccountReviewerPhoto']);
Route::post('/api/updateAccountReviewerPassword', [ApiReviewerController::class, 'updateAccountReviewerPassword']);

Route::get('/api/loa_file', [ApiAdminController::class, 'loa_file']);
Route::get('/api/getNotifAdmin', [ApiAdminController::class, 'getNotifAdmin']);
Route::post('/api/updateNotifAdmin', [ApiAdminController::class, 'updateNotifAdmin']);
Route::post('/api/updateJournalReviewer', [ApiAdminController::class, 'updateJournalReviewer']);
Route::post('/api/updateRevisionAcc', [ApiAdminController::class, 'updateRevisionAcc']);
Route::post('/api/updatePaymentJournal', [ApiAdminController::class, 'updatePaymentJournal']);
Route::post('/api/updatePaymentParticipan', [ApiAdminController::class, 'updatePaymentParticipan']);
Route::post('/api/insertReviewers', [ApiAdminController::class, 'insertReviewers']);
Route::post('/api/updateReviewers', [ApiAdminController::class, 'updateReviewers']);
Route::post('/api/updateReviewersPhoto', [ApiAdminController::class, 'updateReviewersPhoto']);
Route::post('/api/insertCountry', [ApiAdminController::class, 'insertCountry']);
Route::post('/api/updateCountry', [ApiAdminController::class, 'updateCountry']);
Route::post('/api/insertSosmed', [ApiAdminController::class, 'insertSosmed']);
Route::post('/api/updateSosmed', [ApiAdminController::class, 'updateSosmed']);
Route::post('/api/insertDegree', [ApiAdminController::class, 'insertDegree']);
Route::post('/api/updateDegree', [ApiAdminController::class, 'updateDegree']);
Route::post('/api/insertContact', [ApiAdminController::class, 'insertContact']);
Route::post('/api/updateContact', [ApiAdminController::class, 'updateContact']);
Route::post('/api/updateEventActivate', [ApiAdminController::class, 'updateEventActivate']);
Route::post('/api/insertEvents', [ApiAdminController::class, 'insertEvents']);
Route::post('/api/updateEvents', [ApiAdminController::class, 'updateEvents']);
Route::post('/api/insertCoHost', [ApiAdminController::class, 'insertCoHost']);
Route::post('/api/updateCoHost', [ApiAdminController::class, 'updateCoHost']);
Route::post('/api/insertIndexing', [ApiAdminController::class, 'insertIndexing']);
Route::post('/api/updateIndexing', [ApiAdminController::class, 'updateIndexing']);
Route::post('/api/insertTypePayment', [ApiAdminController::class, 'insertTypePayment']);
Route::post('/api/updateTypePayment', [ApiAdminController::class, 'updateTypePayment']);
Route::post('/api/insertCollaboration', [ApiAdminController::class, 'insertCollaboration']);
Route::post('/api/updateCollaboration', [ApiAdminController::class, 'updateCollaboration']);
Route::post('/api/insertKeynoteSpeaker', [ApiAdminController::class, 'insertKeynoteSpeaker']);
Route::post('/api/updateKeynoteSpeaker', [ApiAdminController::class, 'updateKeynoteSpeaker']);
Route::post('/api/insertInvitedSpeaker', [ApiAdminController::class, 'insertInvitedSpeaker']);
Route::post('/api/updateInvitedSpeaker', [ApiAdminController::class, 'updateInvitedSpeaker']);
Route::post('/api/updateSetting', [ApiAdminController::class, 'updateSetting']);
Route::post('/api/updateSettingFoto', [ApiAdminController::class, 'updateSettingFoto']);
Route::post('/api/insertSub', [ApiAdminController::class, 'insertSub']);
Route::post('/api/updateSub', [ApiAdminController::class, 'updateSub']);
Route::post('/api/insertScope', [ApiAdminController::class, 'insertScope']);
Route::post('/api/updateScope', [ApiAdminController::class, 'updateScope']);
Route::post('/api/insertVC', [ApiAdminController::class, 'insertVC']);
Route::post('/api/updateVC', [ApiAdminController::class, 'updateVC']);
Route::post('/api/insertTimeline', [ApiAdminController::class, 'insertTimeline']);
Route::post('/api/updateTimeline', [ApiAdminController::class, 'updateTimeline']);
Route::post('/api/updateAccount', [ApiAdminController::class, 'updateAccount']);
Route::post('/api/updateAccountPassword', [ApiAdminController::class, 'updateAccountPassword']);

Route::get('/api/getNotifParticipan', [ApiParticipanController::class, 'getNotifParticipan']);
Route::post('/api/updateNotifParticipan', [ApiParticipanController::class, 'updateNotifParticipan']);
Route::get('/api/participanPayment', [ApiParticipanController::class, 'participanPayment']);
Route::post('/api/updateParticipanPayment', [ApiParticipanController::class, 'updateParticipanPayment']);
Route::get('/api/journalParticipan', [ApiParticipanController::class, 'journalParticipan']);
Route::get('/api/getVideoParticipan', [ApiParticipanController::class, 'getVideoParticipan']);
Route::post('/api/updateAccountParticipanPhoto', [ApiParticipanController::class, 'updateAccountParticipanPhoto']);
Route::post('/api/updateAccountParticipanPassword', [ApiParticipanController::class, 'updateAccountParticipanPassword']);
Route::get('/api/getAccountParticipan', [ApiParticipanController::class, 'getAccountParticipan']);
Route::post('/api/updateAccountParticipan', [ApiParticipanController::class, 'updateAccountParticipan']);
Route::post('/api/updateAccountParticipanPhoto', [ApiParticipanController::class, 'updateAccountParticipanPhoto']);
Route::post('/api/updateAccountParticipanPassword', [ApiParticipanController::class, 'updateAccountParticipanPassword']);

//--------------------------------------------ADMIN
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/notification', [AdminController::class, 'notification']);
Route::get('/admin/journal', [AdminController::class, 'journal']);
Route::get('/admin/journal/process', [AdminController::class, 'journal_process']);
Route::get('/admin/journal/confirmation', [AdminController::class, 'journal_confirmation']);
Route::get('/admin/journal/draft', [AdminController::class, 'journal_draft']);
Route::get('/admin/journal/detail', [AdminController::class, 'journal_detail']);
Route::get('/admin/revision', [AdminController::class, 'revision']);
Route::get('/admin/revision/detail', [AdminController::class, 'revision_detail']);
Route::get('/admin/payment_journal', [AdminController::class, 'payment_journal']);
Route::get('/admin/payment_participan', [AdminController::class, 'payment_participan']);
Route::get('/admin/videos', [AdminController::class, 'videos']);
Route::get('/admin/videos/abstract', [AdminController::class, 'videos_abstract']);
Route::get('/admin/videos/forum', [AdminController::class, 'videos_forum']);
Route::get('/admin/authors', [AdminController::class, 'authors']);
Route::get('/admin/authors/detail', [AdminController::class, 'authors_detail']);
Route::get('/admin/reviewers', [AdminController::class, 'reviewers']);
Route::get('/admin/reviewers/add', [AdminController::class, 'reviewers_add']);
Route::get('/admin/reviewers/edit', [AdminController::class, 'reviewers_edit']);
Route::get('/admin/participan', [AdminController::class, 'participan']);
Route::get('/admin/participan/detail', [AdminController::class, 'participan_detail']);
Route::get('/admin/country', [AdminController::class, 'country']);
Route::get('/admin/country/add', [AdminController::class, 'country_add']);
Route::get('/admin/country/edit', [AdminController::class, 'country_edit']);
Route::get('/admin/degree', [AdminController::class, 'degree']);
Route::get('/admin/degree/add', [AdminController::class, 'degree_add']);
Route::get('/admin/degree/edit', [AdminController::class, 'degree_edit']);
Route::get('/admin/sosmed', [AdminController::class, 'sosmed']);
Route::get('/admin/sosmed/add', [AdminController::class, 'sosmed_add']);
Route::get('/admin/sosmed/edit', [AdminController::class, 'sosmed_edit']);
Route::get('/admin/contact', [AdminController::class, 'contact']);
Route::get('/admin/contact/add', [AdminController::class, 'contact_add']);
Route::get('/admin/contact/edit', [AdminController::class, 'contact_edit']);
Route::get('/admin/events', [AdminController::class, 'events']);
Route::get('/admin/event/add', [AdminController::class, 'events_add']);
Route::get('/admin/event/edit', [AdminController::class, 'events_edit']);
Route::get('/admin/event/{slug}', [AdminController::class, 'events_detail']);
Route::get('/admin/event/{slug}/edit/{kode}', [AdminController::class, 'events_detail_edit']);
Route::get('/admin/account', [AdminController::class, 'account']);
Route::get('/admin/account/edit', [AdminController::class, 'account_edit']);
Route::get('/admin/account/password', [AdminController::class, 'account_password']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::post('/admin/modal', [AdminController::class, 'modal']);

//--------------------------------------------REVIEWER
Route::get('/reviewer', [ReviewerController::class, 'index']);
Route::get('/reviewer/notification', [ReviewerController::class, 'notification']);
Route::get('/reviewer/journal', [ReviewerController::class, 'journal']);
Route::get('/reviewer/journal/detail', [ReviewerController::class, 'journal_detail']);
Route::get('/reviewer/abstract', [ReviewerController::class, 'abstract']);
Route::get('/reviewer/videos', [ReviewerController::class, 'videos']);
Route::get('/reviewer/videos/abstract', [ReviewerController::class, 'videos_abstract']);
Route::get('/reviewer/videos/forum', [ReviewerController::class, 'videos_forum']);
Route::get('/reviewer/my_question', [ReviewerController::class, 'my_question']);
Route::get('/reviewer/my_question/detail', [ReviewerController::class, 'my_question_detail']);
Route::get('/reviewer/revision', [ReviewerController::class, 'revision']);
Route::get('/reviewer/revision/detail', [ReviewerController::class, 'revision_detail']);
Route::get('/reviewer/my_review', [ReviewerController::class, 'my_review']);
Route::get('/reviewer/my_review/detail', [ReviewerController::class, 'my_review_detail']);
Route::get('/reviewer/account', [ReviewerController::class, 'account']);
Route::get('/reviewer/account/edit', [ReviewerController::class, 'account_edit']);
Route::post('/reviewer/modal', [ReviewerController::class, 'modal']);
Route::get('/reviewer/logout', [ReviewerController::class, 'logout']);

//--------------------------------------------PARTICIPAN
Route::get('/participan', [ParticipanController::class, 'index']);
Route::get('/participan/notification', [ParticipanController::class, 'notification']);
Route::get('/participan/payment', [ParticipanController::class, 'payment']);
Route::get('/participan/journal', [ParticipanController::class, 'journal']);
Route::get('/participan/videos', [ParticipanController::class, 'videos']);
Route::get('/participan/videos/abstract', [ParticipanController::class, 'videos_abstract']);
Route::get('/participan/videos/forum', [ParticipanController::class, 'videos_forum']);
Route::get('/participan/account', [ParticipanController::class, 'account']);
Route::get('/participan/account/edit', [ParticipanController::class, 'account_edit']);
Route::post('/participan/modal', [ParticipanController::class, 'modal']);
Route::get('/participan/logout', [ParticipanController::class, 'logout']);

//--------------------------------------------AUTHOR
Route::get('/author', [AuthorController::class, 'index']);
Route::get('/author/notification', [AuthorController::class, 'notification']);
Route::get('/author/journal', [AuthorController::class, 'journal']);
Route::get('/author/my_journal', [AuthorController::class, 'my_journal']);
Route::get('/author/my_journal/add', [AuthorController::class, 'my_journal_add']);
Route::get('/author/my_journal/detail', [AuthorController::class, 'my_journal_detail']);
Route::get('/author/my_journal/edit', [AuthorController::class, 'my_journal_edit']);
Route::get('/author/my_journal/edit_metadata', [AuthorController::class, 'my_journal_edit_metadata']);
Route::get('/author/videos', [AuthorController::class, 'videos']);
Route::get('/author/videos/abstract', [AuthorController::class, 'videos_abstract']);
Route::get('/author/videos/forum', [AuthorController::class, 'videos_forum']);
Route::get('/author/my_question', [AuthorController::class, 'my_question']);
Route::get('/author/my_question/detail', [AuthorController::class, 'my_question_detail']);
Route::get('/author/qa_forum', [AuthorController::class, 'qa_forum']);
Route::get('/author/qa_forum/detail', [AuthorController::class, 'qa_forum_detail']);
Route::get('/author/revision', [AuthorController::class, 'revision']);
Route::get('/author/revision/detail', [AuthorController::class, 'revision_detail']);
Route::get('/author/account', [AuthorController::class, 'account']);
Route::get('/author/account/edit', [AuthorController::class, 'account_edit']);
Route::get('/author/logout', [AuthorController::class, 'logout']);
Route::post('/author/modal', [AuthorController::class, 'modal']);


Route::get('/export/journal_doc', [ExportController::class, 'journal_doc']);
Route::get('/export/journal_exel', [ExportController::class, 'journal_exel']);
