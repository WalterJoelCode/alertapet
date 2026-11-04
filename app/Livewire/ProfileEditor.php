<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class ProfileEditor extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public ?string $recoveryEmail = null;

    public ?string $alias = null;

    public ?string $phone = null;

    public ?string $instagramHandle = null;

    public ?string $identityNumber = null;

    public ?string $address = null;

    public ?string $addressLine2 = null;

    public ?string $city = null;

    public ?string $state = null;

    public ?int $countryId = null;

    public ?string $postalCode = null;

    public ?string $birthDate = null;

    public ?string $bio = null;

    public bool $termsAccepted = false;

    public ?TemporaryUploadedFile $profilePhoto = null;

    public ?string $currentProfilePhotoPath = null;

    public function mount(): void
    {
        $user = $this->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->recoveryEmail = $user->recovery_email;
        $this->alias = $user->alias;
        $this->phone = $user->phone;
        $this->instagramHandle = $user->instagram_handle;
        $this->identityNumber = $user->identity_number;
        $this->address = $user->address;
        $this->addressLine2 = $user->address_line_2;
        $this->city = $user->city;
        $this->state = $user->state;
        $this->countryId = $user->country_id;
        $this->postalCode = $user->postal_code;
        $this->birthDate = $user->birth_date?->format('Y-m-d');
        $this->bio = $user->bio;
        $this->termsAccepted = $user->terms_accepted;
        $this->currentProfilePhotoPath = $user->profile_photo_path;
    }

    public function save(): void
    {
        $validated = $this->validate();
        $user = $this->user();
        $newProfilePhotoPath = $user->profile_photo_path;

        if ($this->profilePhoto instanceof TemporaryUploadedFile) {
            $newProfilePhotoPath = $this->profilePhoto->store('profile-photos', 'public');
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'recovery_email' => $validated['recoveryEmail'],
            'alias' => $validated['alias'],
            'phone' => $validated['phone'],
            'instagram_handle' => $validated['instagramHandle'],
            'identity_number' => $validated['identityNumber'],
            'address' => $validated['address'],
            'address_line_2' => $validated['addressLine2'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country_id' => $validated['countryId'],
            'postal_code' => $validated['postalCode'],
            'birth_date' => $validated['birthDate'],
            'bio' => $validated['bio'],
            'terms_accepted' => $validated['termsAccepted'],
            'terms_accepted_at' => $user->terms_accepted_at ?? now(),
            'profile_photo_path' => $newProfilePhotoPath,
        ])->save();

        if ($newProfilePhotoPath !== $this->currentProfilePhotoPath && $this->currentProfilePhotoPath !== null) {
            Storage::disk('public')->delete($this->currentProfilePhotoPath);
        }

        $this->currentProfilePhotoPath = $newProfilePhotoPath;
        $this->profilePhoto = null;
        $this->dispatch('profile-saved');
    }

    /** @return array<string, array<int, mixed>> */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user())],
            'recoveryEmail' => ['nullable', 'email', 'max:255', 'different:email', Rule::unique('users', 'recovery_email')->ignore($this->user())],
            'alias' => ['nullable', 'string', 'min:3', 'max:50', 'alpha_dash', Rule::unique('users', 'alias')->ignore($this->user())],
            'phone' => ['nullable', 'string', 'max:32'],
            'instagramHandle' => ['nullable', 'string', 'max:30', 'regex:/^[A-Za-z0-9._]+$/'],
            'identityNumber' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'addressLine2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'state' => ['nullable', 'string', 'max:120'],
            'countryId' => ['nullable', 'integer', Rule::exists('country', 'id')],
            'postalCode' => ['nullable', 'string', 'max:32'],
            'birthDate' => ['nullable', 'date', 'before:today'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'termsAccepted' => ['accepted'],
            'profilePhoto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function render(): View
    {
        return view('livewire.profile-editor', [
            'countries' => Country::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    private function user(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }
}
