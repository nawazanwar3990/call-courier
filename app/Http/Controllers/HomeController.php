<?php

namespace App\Http\Controllers;

use App\Enums\EmailTypeEnum;
use App\Enums\PasswordResetStatusEnum;
use App\Enums\RedeemStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\SubmissionStatusEnum;
use App\Enums\TableEnum;
use App\Http\Requests\ProfileRequest;
use App\Mail\GlobalMail;
use App\Models\GiftCard;
use App\Models\History;
use App\Models\PasswordReset;
use App\Models\Redeem;
use App\Models\RoleUser;
use App\Models\Submission;
use App\Models\Branch;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Notifications\TaskNotification;
use App\Services\GeneralService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tasks = GeneralService::allTasks();
        $params = [
            'pageTitle' => config('app.APP_NAME'),
            'breadcrumbs' => collect([
                __('general.home') => config('app.APP_NAME')
            ]),
            'dailyGiftCards' => GeneralService::getGiftCards(10),
            'tasks' => $tasks
        ];
        return view('website.index', $params);
    }

    public function tasks(Request $request)
    {
        $tasks = GeneralService::allTasks();
        $pageTitle = __('general.daily_tasks');
        $params = [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks
        ];
        return view('website.branches.index', $params);
    }

    public function taskDetail(Request $request, $id)
    {
        $task = Branch::with('submissions', 'userSubmissions', 'createdBy', 'updatedBy')->findOrFail($id);
        $params = [
            'pageTitle' => __('general.detail_of') . ' :: ' . $task->task_name,
            'task' => $task,
        ];
        return view('website.branches.show', $params);
    }

    public function giftCards(Request $request)
    {
        $giftCards = GiftCard::withoutTrashed()->with('type')->orderby('id', 'DESC')->get();
        $pageTitle = __('general.gift_cards');
        $params = [
            'pageTitle' => $pageTitle,
            'giftCards' => $giftCards
        ];
        return view('website.gift-cards', $params);
    }

    public function faqs()
    {
        $pageTitle = __('general.faqs');
        return view('website.faqs.index', ['pageTitle' => $pageTitle]);
    }

    public function getUserProfile()
    {
        $user = Auth::user();
        $pageTitle = __('general.profile');
        return view('website.user-profile', [
            'pageTitle' => $pageTitle,
            'user' => $user
        ]);
    }

    public function updateUserProfile(ProfileRequest $request): JsonResponse
    {
        $return = $request->saveRecord();
        if ($return['success'] === true) {
            return response()->json(['success' => true, 'msg' => $return['msg']]);
        }
        return response()->json(['success' => false, 'msg' => $return['msg']]);
    }

    public function deleteUserProfile(Request $request): JsonResponse
    {
        $userId = $request->input('userId');
        $user = User::find($userId);
        Branch::where('created_by', $userId)->delete();
        RoleUser::where('user_id', $userId)->delete();
        $user->delete();
        return response()->json(['success' => true, 'msg' => trans('general.profile_deleted_successfully')]);
    }

    public function wallet()
    {
        $user = Auth::user();
        $histories = History::with('task', 'giftCard')->where('created_by', $user->id)->paginate(20);
        $pageTitle = __('general.wallet_history');
        $params = [
            'pageTitle' => $pageTitle,
            'user' => $user,
            'histories' => $histories
        ];
        return view('website.wallet', $params);
    }

    public function earningPoints()
    {
        $tasks = GeneralService::allTasks();
        $params = [
            'pageTitle' => config('app.APP_NAME'),
            'breadcrumbs' => collect([
                __('general.home') => config('app.APP_NAME')
            ]),
            'dailyGiftCards' => GeneralService::getGiftCards(10),
            'tasks' => $tasks
        ];
        return view('website.earning-points', $params);
    }

    public function submitTask(Request $request): JsonResponse
    {
        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->username;
        $taskId = $request->input('task_id');
        $submitId = $request->input('submitId', null);

        $task = Branch::active()->withCount('submissions')->findOrFail($taskId);
        $submission_limit = $task->submissions_count;
        $task_limit = $task->task_limit;

        // Check if submission limit has been reached (if limit is not 0 / unlimited)
        if ($task->task_limit !== 0 && $submission_limit >= $task_limit && is_null($submitId)) {
            return response()->json([
                'success' => false,
                'msg' => trans('general.submission_limit_exceeded'),
                'submission_limit' => $submission_limit,
                'task_limit' => $task_limit,
                'status' => $submission_limit >= $task_limit
            ]);
        }
        //create or update submission
        if (DB::table(TableEnum::SUBMISSIONS)->where('id', $submitId)->exists()) {
            $notificationHeading = "Task Re Submitted";
            $notificationDescription = "<span class='text-success'>" . $userName . "</span> has re-submitted a task <span class='text-success'>\"" . $task->task_name . "\"</span>.";
            $submission = Submission::where('id', $submitId)->update([
                'status' => SubmissionStatusEnum::RE_SUBMIT,
                'updated_by' => $userId,
            ]);
        } else {
            $notificationHeading = "Task Submitted";
            $notificationDescription = "<span class='text-success'>" . $userName . "</span> has submitted a task <span class='text-success'>\"" . $task->task_name . "\"</span>.";
            $submission = $task->submissions()->create([
                'created_by' => $userId,
                'updated_by' => $userId,
                'status' => SubmissionStatusEnum::SUBMITTED,
            ]);
        }

        if ($request->hasFile('image')) {
            $submission->addMediaFromRequest('image')->toMediaCollection('image');
        }
        //Manage Notifications
        $receiver = UserService::findByRoleName(RoleEnum::ROLE_SUPER_ADMIN);
        $receiver->notify(new TaskNotification($notificationHeading, $notificationDescription));

        return response()->json([
            'success' => true,
            'msg' => trans('general.task_submitted_successfully'),
            'task' => $task,
            'submission_limit' => $submission_limit,
            'task_limit' => $task_limit
        ]);
    }

    public function termsConditions()
    {
        $pageTitle = __('general.terms_conditions');
        return view('website.term-conditions', ['pageTitle' => $pageTitle]);
    }

    public function privacyPolicy()
    {
        $pageTitle = __('general.privacy_policy');
        return view('website.privacy-policy', ['pageTitle' => $pageTitle]);
    }

    public function redeemRequest(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        $gift_card_id = $request->input('gift_card_id');

        $user = User::find($userId);
        $giftCard = GiftCard::find($gift_card_id);

        Redeem::create([
            'gift_card_id' => $giftCard->id,
            'status' => RedeemStatusEnum::REQUESTED,
            'created_by' => $userId,
            'updated_by' => $userId
        ]);

        $user->total_coins = max(0, (int)$user->total_coins - (int)$giftCard->point_cost);
        $user->save();

        //update history
        History::create([
            'gift_card_id' => $giftCard->id,
            'created_by' => $userId,
            'updated_by' => $userId,
            'coins' => $giftCard->point_cost
        ]);

        $receiver = UserService::findByRoleName(RoleEnum::ROLE_SUPER_ADMIN);
        $receiver->notify(new TaskNotification(
            'Redeem Request',
            '<span class="text-success">' . $user->username . '</span> has submitted a redeem request for the gift card <span class="text-success">"' . $giftCard->name . '"</span>.'
        ));

        return response()->json([
            'success' => true,
            'msg' => trans('general.task_submitted_successfully')
        ]);
    }

    public function passwordRequest(Request $request): JsonResponse
    {
        $email = $request->input('email', null);
        $receiver = UserService::findByRoleName(RoleEnum::ROLE_SUPER_ADMIN);
        $sender = User::whereEmail($email)->first();

        if (!$sender) {
            return response()->json([
                'success' => false,
                'msg' => 'User with this email does not exist.'
            ]);
        }

        $model = PasswordReset::create([
            'status' => PasswordResetStatusEnum::REQUESTED,
            'created_by' => $sender->id
        ])->load('createdBy');

        Mail::to($receiver->email)->send(new GlobalMail(
            EmailTypeEnum::PASSWORD_RESET_REQUESTED,
            EmailTypeEnum::getTranslationKeyBy(EmailTypeEnum::PASSWORD_RESET_REQUESTED),
            $model
        ));

        $receiver->notify(new PasswordResetNotification(
            EmailTypeEnum::getTranslationKeyBy(EmailTypeEnum::PASSWORD_RESET_REQUESTED),
            '<span class="text-success">' . $sender->username . '</span> has submitted a request for password change.<a href="' . route('admin.password.change',$model->id) . '" style="color:#0d6efd; text-decoration:underline;">Click here to reset the password</a>'
        ));

        return response()->json([
            'success' => true,
            'msg' => 'Request for password reset successfully submitted to admin. We will notify you via email with your new password.'
        ]);
    }

}
