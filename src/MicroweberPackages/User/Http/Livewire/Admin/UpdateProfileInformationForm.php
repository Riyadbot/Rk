<?php

namespace MicroweberPackages\User\Http\Livewire\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use MicroweberPackages\User\Models\User;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;


    public $userId = false;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount($userId = false)
    {
        if ($userId) {
            $this->userId = $userId;
            $this->state = User::where('id', $userId)->first()->withoutRelations()->toArray();
        } else {
            $this->state = Auth::user()->withoutRelations()->toArray();
        }

        $this->photo = user_picture($this->state['id']);
    }

    /**
     * Update the user's profile information.
     * @return void
     */
    public function updateProfileInformation()
    {
        $this->resetErrorBag();

        if ($this->userId) {
            $user = User::where('id', $this->userId)->first();
        } else {
            $user = Auth::user();
        }

        $input = $this->photo
            ? array_merge($this->state, ['thumbnail' => $this->photo])
            : $this->state;


        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');


        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
            ])->save();
        }

        if (isset($this->photo)) {
            return redirect()->route('admin.profile.show');
        }

        $this->emit('saved');
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('admin::livewire.edit-user.update-profile-information-form');
    }
}
