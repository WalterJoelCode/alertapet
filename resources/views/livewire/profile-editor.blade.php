<div>
    <section class="border-b border-pet-charcoal/10 bg-pet-surface py-6 sm:py-8">
        <div class="page-shell flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="eyebrow">Mi perfil</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-pet-deep sm:text-4xl">Tu información en AlertaPet.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-pet-muted sm:text-base">Completa los datos que te ayuden a colaborar y mantener protegida tu cuenta.</p>
            </div>
            <a href="{{ route('inicio') }}" class="button-secondary self-start md:self-auto"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Volver a mi cuenta</a>
        </div>
    </section>

    <section class="py-8 sm:py-10">
        <div class="page-shell max-w-5xl">
            <form wire:submit="save" class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]" enctype="multipart/form-data">
                <div class="surface-card p-5 sm:p-7">
                    <div class="flex items-center justify-between gap-4 border-b border-pet-charcoal/10 pb-5">
                        <div>
                            <h2 class="text-xl font-black text-pet-deep">Datos personales</h2>
                            <p class="mt-1 text-sm text-pet-muted">Los campos marcados con * son necesarios.</p>
                        </div>
                        <span class="status-badge">{{ auth()->user()->role?->name ?? 'General' }}</span>
                    </div>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Nombre completo *<input wire:model="name" type="text" autocomplete="name" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('name')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Alias público<input wire:model="alias" type="text" autocomplete="nickname" placeholder="Ej. paula_con_mascotas" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('alias')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Correo electrónico *<input wire:model="email" type="email" autocomplete="email" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('email')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Correo de recuperación<input wire:model="recoveryEmail" type="email" autocomplete="email" placeholder="Distinto a tu correo principal" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('recoveryEmail')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Teléfono<input wire:model="phone" type="tel" autocomplete="tel" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('phone')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Instagram<input wire:model="instagramHandle" type="text" autocomplete="off" placeholder="usuario, sin @" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('instagramHandle')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        <label class="grid gap-2 text-sm font-bold text-pet-deep">Fecha de nacimiento<input wire:model="birthDate" type="date" autocomplete="bday" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('birthDate')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                    </div>

                    <div class="mt-8 border-t border-pet-charcoal/10 pt-6">
                        <h2 class="text-xl font-black text-pet-deep">Ubicación y contacto</h2>
                        <p class="mt-1 text-sm text-pet-muted">Comparte solo los datos necesarios para coordinar ayuda cuando tú lo decidas.</p>
                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <label class="grid gap-2 text-sm font-bold text-pet-deep sm:col-span-2">Dirección<input wire:model="address" type="text" autocomplete="street-address" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('address')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep sm:col-span-2">Referencia o complemento<input wire:model="addressLine2" type="text" autocomplete="address-line2" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('addressLine2')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">Ciudad<input wire:model="city" type="text" autocomplete="address-level2" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('city')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">Departamento / estado<input wire:model="state" type="text" autocomplete="address-level1" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('state')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">País<select wire:model="countryId" autocomplete="country-name" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong"><option value="">Selecciona un país</option>@foreach ($countries as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach</select>@error('countryId')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">Código postal<input wire:model="postalCode" type="text" autocomplete="postal-code" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('postalCode')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-pet-charcoal/10 pt-6">
                        <h2 class="text-xl font-black text-pet-deep">Información adicional</h2>
                        <div class="mt-5 grid gap-5">
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">Cédula de identidad<span class="text-xs font-normal text-pet-muted">Se guarda cifrada y no se muestra públicamente.</span><input wire:model="identityNumber" type="text" autocomplete="off" class="min-h-12 rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong">@error('identityNumber')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                            <label class="grid gap-2 text-sm font-bold text-pet-deep">Sobre ti<textarea wire:model="bio" rows="4" maxlength="1000" class="rounded-xl border border-pet-charcoal/20 bg-pet-cream px-3 py-3 font-normal text-pet-ink outline-none focus:border-pet-gold-strong" placeholder="Cuéntale brevemente a la comunidad cómo quieres ayudar."></textarea>@error('bio')<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-pet-charcoal/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <label class="flex max-w-lg items-start gap-3 text-xs leading-5 text-pet-muted"><input wire:model="termsAccepted" type="checkbox" class="mt-0.5 size-4 accent-pet-primary"> <span>Confirmo que leí y acepto los términos y condiciones del servicio.</span></label>
                        <button type="submit" class="button-primary" wire:loading.attr="disabled" wire:target="save,profilePhoto"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Guardar perfil</button>
                    </div>
                    @error('termsAccepted')<p class="mt-2 text-xs font-bold text-red-700">{{ $message }}</p>@enderror
                </div>

                <aside class="surface-card h-fit p-5 sm:p-6">
                    <h2 class="text-lg font-black text-pet-deep">Foto de perfil</h2>
                    <div class="mt-5 grid justify-items-center gap-4 text-center">
                        @if ($profilePhoto)
                            <img src="{{ $profilePhoto->temporaryUrl() }}" alt="Vista previa de tu nueva foto de perfil" class="size-28 rounded-full object-cover ring-4 ring-pet-surface">
                        @elseif ($currentProfilePhotoPath)
                            <img src="{{ asset('storage/'.$currentProfilePhotoPath) }}" alt="Foto de perfil de {{ $name }}" class="size-28 rounded-full object-cover ring-4 ring-pet-surface">
                        @else
                            <span class="grid size-28 place-items-center rounded-full bg-pet-surface text-3xl font-black text-pet-gold-strong">{{ strtoupper(substr($name, 0, 1)) }}</span>
                        @endif
                        <label class="button-secondary w-full cursor-pointer"><i class="fa-solid fa-camera" aria-hidden="true"></i> Elegir foto<input wire:model="profilePhoto" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only"></label>
                        <p class="text-xs leading-5 text-pet-muted">JPG, PNG o WebP. Máximo 2 MB.</p>
                        @error('profilePhoto')<p class="text-xs font-bold text-red-700">{{ $message }}</p>@enderror
                    </div>
                </aside>
            </form>

            <div x-data="{ visible: false }" x-on:profile-saved.window="visible = true; setTimeout(() => visible = false, 4000)" x-show="visible" x-transition class="fixed inset-x-5 bottom-5 z-50 mx-auto max-w-md rounded-xl bg-pet-charcoal px-4 py-3 text-sm font-bold text-pet-cream shadow-xl" role="status">Tu perfil se actualizó correctamente.</div>
        </div>
    </section>
</div>
