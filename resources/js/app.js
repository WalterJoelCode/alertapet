import Swal from 'sweetalert2';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
window.upcomingProvider = () => Swal.fire({ icon: 'info', title: 'Próximamente disponible', text: 'Estamos preparando este acceso seguro para ti.', confirmButtonColor: '#C65A3A' });
Livewire.start();
