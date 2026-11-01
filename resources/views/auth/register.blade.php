<x-layouts.app>
    <section class="bg-pet-surface py-12 sm:py-20"><div class="page-shell max-w-xl"><div class="rounded-3xl border border-pet-charcoal/10 bg-white p-6 shadow-[0_16px_45px_rgb(44_49_54_/_0.08)] sm:p-10"><p class="eyebrow">Crear cuenta</p><h1 class="mt-3 text-3xl font-black text-pet-charcoal">Únete a la comunidad.</h1><p class="mt-2 max-w-md text-sm leading-6 text-pet-slate">Tu cuenta te permitirá publicar, gestionar perfiles de mascotas y colaborar con la red.</p>
        <form class="mt-7 grid gap-5" method="POST" action="{{ route('register.store') }}">@csrf
            @foreach ([['name', 'Nombre', 'text', 'name'], ['email', 'Correo electrónico', 'email', 'email'], ['password', 'Contraseña', 'password', 'new-password'], ['password_confirmation', 'Confirmar contraseña', 'password', 'new-password']] as [$name, $label, $type, $autocomplete])
                <label class="grid gap-2 text-sm font-bold text-pet-charcoal">{{ $label }}<input name="{{ $name }}" type="{{ $type }}" value="{{ $type !== 'password' ? old($name) : '' }}" required autocomplete="{{ $autocomplete }}" class="min-h-12 rounded-xl border border-pet-charcoal/20 px-3 font-normal text-pet-charcoal outline-none focus:border-pet-gold-strong">@error($name)<span class="text-xs font-normal text-red-700">{{ $message }}</span>@enderror</label>
            @endforeach
            <button class="button-primary mt-1 w-full" type="submit">Crear mi cuenta <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
        </form>
        <p class="mt-7 text-center text-sm text-pet-slate">¿Ya tienes una cuenta? <a class="font-bold text-pet-gold-strong underline-offset-4 hover:underline" href="{{ route('login') }}">Inicia sesión</a></p>
    </div></div></section>
</x-layouts.app>
