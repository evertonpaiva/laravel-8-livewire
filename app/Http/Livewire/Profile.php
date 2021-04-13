<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    /**
     * Put your custom public properties here!
     */
    public string $email;
    public string $nome;

    /**
     * The validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'email' => 'required|email'
        ];
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return array
     */
    public function modelData()
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
        ];
    }

    public function mount()
    {
        $this->nome = auth()->user()->nome;
        $this->email = auth()->user()->email;
    }


    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return User::find(auth()->user()->id);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        User::find(auth()->user()->id)->update($this->modelData());
        $this->emit('saved');
    }

    public function render()
    {
        return view('profile.info', [
            'data' => $this->read(),
        ]);
    }
}
