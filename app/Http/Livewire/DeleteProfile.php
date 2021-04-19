<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Livewire\Component;
use App\Actions\Ufvjm\AuthContaInstitucional;

class DeleteProfile extends Component
{
    /**
     * Indicates if user deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingUserDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public $password = '';

    /**
     * Confirm that the user would like to delete their account.
     *
     * @return void
     */
    public function confirmUserDeletion()
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->confirmingUserDeletion = true;
    }

    /**
     * Delete the current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Jetstream\Contracts\DeletesUsers  $deleter
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request, DeletesUsers $deleter, StatefulGuard $auth)
    {
        $this->resetErrorBag();

        try {
            $loginInfo = new \stdClass();

            $loginInfo->containstitucional = $auth->user()->containstitucional;
            $loginInfo->password = $this->password;

            $authContaInstitucional = new AuthContaInstitucional();

            // Tenta logar
            $authContaInstitucional->logarContaInstitucional($loginInfo);

            // Logou com sucesso, apagando usuario
            $deleter->delete(Auth::user()->fresh());

            $auth->logout();

            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            $this->redirect(env('APP_URL'));
        } catch (\Exception $e) {
            $this->addError('password', 'Senha inválida');
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile.delete-user-form');
    }
}
