<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
 dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="light">
 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ config('app.name', 'AgendaApp') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="{{asset('/css/newStyles.css')}}" rel="stylesheet"/>
        <style>
            .flatpickr-calendar .flatpickr-day.disabled {
                background-color: #f0f0f0 !important;
                color: #d3d3d3 !important;
                cursor: not-allowed !important;
                opacity: 0.6 !important;
            }
        
            .flatpickr-calendar .flatpickr-day.disabled:hover {
                background-color: #f0f0f0 !important;
                color: #d3d3d3 !important;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{asset('resources/css/app.css')}}"/>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="preload" as="style" href="{{asset('/build/assets/app-BEmGdVaN.css')}}" /><link rel="stylesheet" href="{{asset('/build/assets/app-BEmGdVaN.css')}}" />

        <!-- TITLE -->
        <title> Crear citas - Cliente </title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="build/assets/images/brand-logos/favicon.ico">

        <!-- Main Theme Js -->
        <script src="build/assets/main.js"></script>

        <!-- ICONS CSS -->
        <link href="build/assets/iconfonts/icons.css" rel="stylesheet">
      
        <!-- APP CSS & APP SCSS -->
        <link rel="preload" as="style" href="build/assets/app-BEmGdVaN.css" /><link rel="stylesheet" href="build/assets/app-BEmGdVaN.css" />
        <!-- Simplebar Css -->
        <link rel="stylesheet" href="build/assets/libs/simplebar/simplebar.min.css">

        <!-- Color Picker Css -->
        <link rel="stylesheet" href="build/assets/libs/%40simonwep/pickr/themes/nano.min.css">
        
        <!-- Choices Css -->
        <link rel="stylesheet" href="build/assets/libs/choices.js/public/assets/styles/choices.min.css">
        <link rel="stylesheet" href="build/assets/libs/glightbox/css/glightbox.min.css">

<!--cambiar a vite-->
    <link href="{{ asset('/css/assets/iconfonts/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/app-template.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/@simonwep/pickr/themes/nano.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/tom-select/css/tom-select.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/tabulator-tables/css/tabulator.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet">
    </head>


	    <!-- Additional Vite Scripts -->
</head>
    <body class="">


        <!-- Loader -->
        <div id="loader" >
            <img src="build/assets/images/media/loader.svg" alt="">
        </div>
        <!-- Loader -->

        <div class="page">
            <!-- Main-Header -->
            <header class="app-header" style="border: none; background-color: transparent !important; box-shadow: none !important">
					<nav class="main-header" aria-label="Global">
						<div class="main-header-container !px-[0.85rem]">

						<div class="header-content-left">
							<div class="header-element !items-center">
							</div>
						</div>
						<div class="header-content-right">
							<!-- light and dark theme -->
							<div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] !px-[0.65rem]">
                                <!-- Dark mode button -->
                                <button 
                                    id="darkModeToggle"
                                    class="flex hs-dark-mode-active:hidden justify-center items-center gap-2 rounded-full font-medium transition-all text-xs"
                                    data-hs-theme-click-value="dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 -960 960 960" width="24">
                                        <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"/>
                                    </svg>
                                </button>
                                <!-- Light mode button -->
                                <button 
                                    id="lightModeToggle"
                                    class="hidden justify-center items-center gap-2 rounded-full font-medium text-white transition-all text-xs hover:bg-black/10"
                                    data-hs-theme-click-value="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 -960 960 960" width="24" >
                                        <path d="M480-360q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0 80q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Zm326-268Z"/>
                                    </svg>
                                </button>
                            </div>
							<!-- End light and dark theme -->
                            <!-- share button -->
							<div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] !px-[0.65rem]">
                                <button 
                                    onclick="shareLink()"
                                    class="flex justify-center items-center gap-2 rounded-full font-medium transition-all text-xs hover:bg-black/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.03-.47-.09-.7l7.05-4.11c.53.5 1.21.81 1.96.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.03.47.09.7L8.91 9.81c-.53-.5-1.21-.81-1.96-.81-1.66 0-3 1.34-3 3s1.34 3 3 3c.75 0 1.43-.31 1.96-.81l7.05 4.11c-.05.23-.09.46-.09.7 0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3z" />
                                    </svg>
                                </button>
                            </div>
                            
                            <script>
                            function shareLink() {
                                if (navigator.share) {
                                    navigator.share({
                                        title: 'Clínica Veterinaria Peninsular',
                                        url: window.location.href
                                    }).catch(console.error);
                                } else {
                                    const dummy = document.createElement('input');
                                    document.body.appendChild(dummy);
                                    dummy.value = window.location.href;
                                    dummy.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(dummy);
                                    alert('Link copiado al portapapeles');
                                }
                            }
                            </script>
                            <!-- End share button -->
						</div>
						</div>
					</nav>
				</header>
			<!-- End Main-Header -->

            <!-- Start::content  -->
            <style>
                @media (min-width: 1024px) {
                    .content {
                        padding: 0 30rem;
                    }
                }
            </style>
            <div class="content" style="margin-inline:0rem">
                <!-- Start::main-content -->
				<div class="main-content">
                  @yield('content')
                  <!-- Page Header -->
                  
                    <!-- Page Header Close -->
                    <!-- Start::row-1 -->
                    <div class="grid grid-cols-4 gap-x-6">
                        <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
                            <div class="box overflow-hidden">

                                <div class="box-body dark:bg-navy-800 !p-0">
                                    <div class="sm:flex items-start !py-6 px-4 main-profile-cover dark:bg-navy-800" style="background-color: #59C2CB !important">
                                        <div class="flex-grow main-profile-info">
                                            <div class="flex items-center !justify-between" style="margin-top: 0; padding-top: 10px; padding-bottom: 10px; padding-left: 20px">
                                                <div class="md:flex block items-center justify-between mb-2 mt-0 page-header-breadcrumb" style="margin: 0;">
                                                    <div style="display: flex; align-items: center;">
                                                        <span class="avatar avatar-xxl avatar-rounded me-4">
                                                            <img src="{{asset('/css/assets/icons/CVP.png')}}" alt="">
                                                        </span>
                                                        <div class="my-auto">
                                                            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Clínica Veterinaria</h5>
                                                            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Peninsular</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="widget-container" class="box-body dark:bg-navy-800 !important" style="background-color: white">
                                        <div class="widget active" id="form-widget">
                                            <form id="appointmentForm" class="grid grid-cols-12 sm:gap-x-6 sm:gap-y-4">
                                                <div class="md:col-span-6 col-span-12 mb-4">
                                                    <label class="form-label">Nombre del paciente (mascota)</label>
                                                    <input type="text" name="pet_name" class="form-control dark:bg-navy-700 dark:text-white dark:border-navy-500" 
                                                        placeholder="Nombre de la mascota" required>
                                                </div>
                                                <div class="md:col-span-6 col-span-12 mb-4">
                                                    <label class="form-label">Especie</label>
                                                    <select name="species" class="form-control dark:bg-navy-700 dark:text-white dark:border-navy-500" required>
                                                        <option value="">Seleccione una especie</option>
                                                        <option value="perro">Perro</option>
                                                        <option value="gato">Gato</option>
                                                    </select>
                                                </div>
                                                <div class="md:col-span-6 col-span-12 mb-4">
                                                    <label class="form-label">Nombre del propietario</label>
                                                    <input type="text" name="name" class="form-control dark:bg-navy-700 dark:text-white dark:border-navy-500 placeholder:text-textmuted" 
                                                        placeholder="Nombre completo del propietario" required>
                                                </div>
                                                <div class="md:col-span-6 col-span-12 mb-4">
                                                    <label class="form-label">Número de contacto</label>
                                                    <input 
                                                        type="tel" 
                                                        name="contact_number" 
                                                        class="form-control dark:bg-navy-700 dark:text-white dark:border-navy-500 placeholder:text-textmuted"
                                                        placeholder="Número de contacto (10 dígitos)" 
                                                        pattern="[0-9]{10}"
                                                        maxlength="10"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        required
                                                    >
                                                    <span id="phoneError" class="text-red-500 text-sm hidden">El número debe tener 10 dígitos</span>
                                                </div>
                                                <div class="md:col-span-6 col-span-12 mb-4">
                                                    <label class="form-label">Motivo de consulta</label>
                                                    <textarea name="treatment" class="form-control dark:bg-navy-700 dark:text-white dark:border-navy-500 placeholder:text-textmuted" 
                                                        placeholder="Describa el motivo de la consulta" required></textarea>
                                                </div>
                                                <div class="md:col-span-12 col-span-12 flex justify-center">
                                                    <button 
                                                        type="button"
                                                        id="continueButton"
                                                        class="ti-btn ti-btn-primary-full !mb-1"
                                                        style="background-color: #59C2CB; color: white; border: none; padding: 10px 20px; border-radius: 5px;">
                                                        Continuar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="widget" id="calendar-widget" style="display: none;">
                                            <div class="calendar-header dark:bg-navy-800">
                                                <h3 class="calendar-title">Selecciona tu horario</h3>
                                                <div class="month-selector">
                                                    <button class="month-nav prev-month dark:text-white dark:hover:bg-navy-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg>
                                                    </button>
                                                    <span class="current-month">Abril 2024</span>
                                                    <button class="month-nav dark:text-white dark:hover:bg-navy-600 next-month">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="9 18 15 12 9 6"></polyline>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="calendar-body">
                                                <div class="calendar-grid dark:bg-navy-800">
                                                    <div class="weekdays">
                                                        <div>Dom</div>
                                                        <div>Lun</div>
                                                        <div>Mar</div>
                                                        <div>Mie</div>
                                                        <div>Jue</div>
                                                        <div>Vie</div>
                                                        <div>Sab</div>
                                                    </div>
                                                    <div id="calendar-days"></div>
                                                </div>
                                                
                                                <div class="time-slots">
                                                    <div class="time-slot-grid dark:bg-navy-800">
                                                        <button class="time-slot">8:00 A.M.</button>
                                                        <button class="time-slot">9:00 A.M.</button>
                                                        <button class="time-slot">11:30 A.M.</button>
                                                        <button class="time-slot">12:00 P.M.</button>
                                                        <button class="time-slot">3:00 P.M.</button>
                                                        <button class="time-slot">4:00 P.M.</button>
                                                        <button class="time-slot">4:30 P.M.</button>
                                                        <button class="time-slot">6:00 P.M.</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="button-group">
                                                <button type="button" id="backButton" class="ti-btn ti-btn-secondary-full">
                                                    Regresar
                                                </button>
                                                <button type="submit" id="submitButton" class="ti-btn ti-btn-primary-full" style="background-color: #59C2CB;">
                                                    Enviar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <div class="box-footer hidden border-t-0">
                            </div>
                    <!--End::row-1 -->
				</div>
            </div>
            <!-- End::content  -->

            <!-- Footer opened -->
            <footer class="footer mt-auto  font-normal font-inter bg-transparent  leading-normal !text-[0.875rem] dark:bg-transparent py-4 text-center">
															<div class="container">
																<a href="javascript:void(0);" class="text-defaulttextcolor font-semibold dark:text-defaulttextcolor"></a>
																	by Koda Solutions <a href="javascript:void(0);">
																		<span class="font-semibold text-primary underline"></span>
																	</a>
																</span>
															</div>
												</footer>
            <!-- End Footer -->
        </div>
        <!-- SCRIPTS -->
        <!-- Back To Top -->
         <div class="scrollToTop">
            <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
         </div>

         <div id="responsive-overlay"></div>

         <!-- popperjs -->

         <script>

            document.addEventListener('DOMContentLoaded', function() {
                const darkModeToggle = document.getElementById('darkModeToggle');
                const lightModeToggle = document.getElementById('lightModeToggle');
                
                function setTheme(theme) {
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        darkModeToggle.classList.add('hidden');
                        lightModeToggle.classList.remove('hidden');
                        // Añadir clases específicas para dark mode
                        document.body.classList.add('dark-theme');
                    } else {
                        document.documentElement.classList.remove('dark');
                        darkModeToggle.classList.remove('hidden');
                        lightModeToggle.classList.add('hidden');
                        // Remover clases específicas para dark mode
                        document.body.classList.remove('dark-theme');
                    }
                    localStorage.setItem('theme', theme);
                }
                
                darkModeToggle.addEventListener('click', () => setTheme('dark'));
                lightModeToggle.addEventListener('click', () => setTheme('light'));
                
                // Cargar tema guardado o usar el predeterminado
                const savedTheme = localStorage.getItem('theme') || 'light';
                setTheme(savedTheme);
            });
            
            document.addEventListener('DOMContentLoaded', function() {
                const formWidget = document.getElementById('form-widget');
                const calendarWidget = document.getElementById('calendar-widget');
                const appointmentForm = document.getElementById('appointmentForm');
                const phoneInput = appointmentForm.querySelector('input[name="contact_number"]');
                const phoneError = document.getElementById('phoneError');
                const continueButton = document.getElementById('continueButton');
                const backButton = document.getElementById('backButton');
                const submitButton = document.getElementById('submitButton');
                const prevMonth = document.querySelector('.prev-month');
                const nextMonth = document.querySelector('.next-month');
                const currentMonthElement = document.querySelector('.current-month');
                const today = new Date();
                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

                let formData = {};
                let selectedDate = null;
                let selectedTime = null;
                let selectedTime24h = null;
                let currentDate = new Date();

                // Event listener para validación del teléfono
                phoneInput.addEventListener('input', function() {
                    const isValid = this.value.length === 10 && /^[0-9]{10}$/.test(this.value);
                    
                    if (!isValid && this.value.length > 0) {
                        phoneError.classList.remove('hidden');
                        this.classList.add('border-red-500');
                    } else {
                        phoneError.classList.add('hidden');
                        this.classList.remove('border-red-500');
                    }
                });
                
                function getDaysInMonth(year, month) {
                    return new Date(year, month + 1, 0).getDate();
                }

                function getFirstDayOfMonth(year, month) {
                    const firstDay = new Date(year, month, 2).getDay();
                    return firstDay === 0 ? 7 : firstDay;
                }

                function updateCalendar() {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();
                    const today = new Date();
                    currentMonthElement.textContent = `${months[month]} ${year}`;
                    
                    const calendarDays = document.getElementById('calendar-days');
                    calendarDays.innerHTML = '';
                    
                    const firstDay = getFirstDayOfMonth(year, month);
                    const daysInPrevMonth = getDaysInMonth(year, month - 1);
                    const daysInCurrentMonth = getDaysInMonth(year, month);
                    
                    // Días del mes anterior
                    for (let i = firstDay - 1; i > 0; i--) {
                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'calendar-day prev-month-day disabled';
                        dayDiv.textContent = daysInPrevMonth - i + 1;
                        calendarDays.appendChild(dayDiv);
                    }
                    
                    // Días del mes actual
                    for (let i = 1; i <= daysInCurrentMonth; i++) {
                        const dayDiv = document.createElement('div');
                        const dateToCheck = new Date(year, month, i);
                        const isPastDay = dateToCheck < new Date(today.getFullYear(), today.getMonth(), today.getDate());
                        const isToday = i === today.getDate() && 
                                    month === today.getMonth() && 
                                    year === today.getFullYear();
                        
                        dayDiv.className = `calendar-day current-month-day ${isPastDay ? 'disabled' : ''}`;
                        dayDiv.textContent = i;
                        
                        if (!isPastDay) {
                            dayDiv.addEventListener('click', function() {
                                document.querySelectorAll('.calendar-day').forEach(day => {
                                    day.classList.remove('selected');
                                });
                                document.querySelectorAll('.time-slot').forEach(slot => {
                                    slot.classList.remove('selected');
                                });
                                selectedTime = null;
                                selectedTime24h = null;
                                this.classList.add('selected');
                                selectedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
                                updateTimeSlots();
                            });
                        }

                        if (isToday) {
                            dayDiv.classList.add('selected');
                            selectedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
                        }
                        
                        calendarDays.appendChild(dayDiv);
                    }
                    
                    // Días del mes siguiente
                    const totalCells = 42;
                    const remainingCells = totalCells - (firstDay - 1 + daysInCurrentMonth);
                    for (let i = 1; i <= remainingCells; i++) {
                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'calendar-day next-month-day disabled';
                        dayDiv.textContent = i;
                        calendarDays.appendChild(dayDiv);
                    }
                }

                function generateTimeSlots() {
                    const timeSlotsContainer = document.querySelector('.time-slot-grid');
                    timeSlotsContainer.innerHTML = '';
                    
                    for (let hour = 8; hour <= 19.5; hour += 0.5) {
                        const hourFloor = Math.floor(hour);
                        const minutes = hour % 1 === 0 ? '00' : '30';
                        
                        const time24h = `${hourFloor.toString().padStart(2, '0')}:${minutes}`;
                        const timeFormatted = formatTime(time24h);
                        
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'time-slot';
                        button.textContent = timeFormatted;
                        button.dataset.time24h = time24h;
                        
                        button.addEventListener('click', function() {
                            if (!this.classList.contains('disabled')) {
                                document.querySelectorAll('.time-slot.selected').forEach(el => {
                                    el.classList.remove('selected');
                                });
                                this.classList.add('selected');
                                selectedTime = this.textContent;
                                selectedTime24h = this.dataset.time24h;
                            }
                        });
                        
                        timeSlotsContainer.appendChild(button);
                    }
                    updateTimeSlots();
                }

                function formatTime(time24h) {
                    const [hours, minutes] = time24h.split(':');
                    let period = 'A.M.';
                    let hour = parseInt(hours);
                    
                    if (hour >= 12) {
                        period = 'P.M.';
                        if (hour > 12) hour -= 12;
                    }
                    if (hour === 0) hour = 12;
                    
                    return `${hour}:${minutes} ${period}`;
                }

                function updateTimeSlots() {
                    const now = new Date();
                    const selectedDay = selectedDate ? new Date(selectedDate + 'T00:00:00') : now;

                    const todayDate = new Date(
                        now.getFullYear(),
                        now.getMonth(),
                        now.getDate()
                    ).getTime();

                    const selectedDateObj = new Date(
                        selectedDay.getFullYear(),
                        selectedDay.getMonth(),
                        selectedDay.getDate()
                    ).getTime();

                    const isToday = todayDate === selectedDateObj;
                    const currentHour = now.getHours();
                    const currentMinutes = now.getMinutes();

                    document.querySelectorAll('.time-slot').forEach(slot => {
                        const [hours, minutes] = slot.dataset.time24h.split(':');
                        const slotHour = parseInt(hours);
                        const slotMinutes = parseInt(minutes);

                        if (selectedDateObj < todayDate) {
                            slot.classList.add('disabled');
                            slot.disabled = true;
                        } else if (isToday) {
                            if (slotHour < currentHour || 
                                (slotHour === currentHour && slotMinutes <= currentMinutes)) {
                                slot.classList.add('disabled');
                                slot.disabled = true;
                            } else {
                                slot.classList.remove('disabled');
                                slot.disabled = false;
                            }
                        } else {
                            slot.classList.remove('disabled');
                            slot.disabled = false;
                        }
                    });
                }

                // Event listener para el botón continuar
                continueButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Validar el número de teléfono
                    const phoneNumber = phoneInput.value;
                    const isPhoneValid = phoneNumber.length === 10 && /^[0-9]{10}$/.test(phoneNumber);
                    
                    if (!isPhoneValid) {
                        phoneError.classList.remove('hidden');
                        phoneInput.classList.add('border-red-500');
                        phoneInput.focus();
                        return;
                    }
                    
                    // Validar el resto del formulario
                    let isFormValid = true;
                    const formElements = appointmentForm.elements;
                    
                    // Limpiar formData antes de actualizarlo
                    formData = {};
                    
                    for (let element of formElements) {
                        if (element.hasAttribute('required') && !element.value) {
                            isFormValid = false;
                            element.classList.add('border-red-500');
                        } else if (element.name) {
                            formData[element.name] = element.value;
                            element.classList.remove('border-red-500');
                        }
                    }
                    
                    if (!isFormValid) {
                        return;
                    }
                    
                    // Si todo es válido, mostrar el calendario
                    formWidget.style.display = 'none';
                    calendarWidget.style.display = 'block';
                    updateTimeSlots();
                });

                backButton.addEventListener('click', function() {
                    calendarWidget.style.display = 'none';
                    formWidget.style.display = 'block';
                });

                document.querySelectorAll('.time-slot').forEach(slot => {
                    slot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot.selected').forEach(el => {
                            el.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        selectedTime = this.textContent;
                        console.log('Hora seleccionada:', selectedTime);
                    });
                });

                function convertTo24Hour(time12h) {
                    const [time, modifier] = time12h.split(' ');
                    let [hours, minutes] = time.split(':');

                    if (hours === '12') {
                        hours = '00';
                    }

                    if (modifier === 'P.M.') {
                        hours = parseInt(hours, 10) + 12;
                    }

                    return `${hours.toString().padStart(2, '0')}:${minutes}`;
                }

                submitButton.addEventListener('click', function() {
                    console.log('Estado actual:', { selectedDate, selectedTime, formData });
                    
                    if (!selectedDate || !selectedTime) {
                        alert('Por favor selecciona fecha y hora');
                        return;
                    }

                    const time24h = convertTo24Hour(selectedTime);
                    const appointmentData = {
                        client_id: 0,
                        is_web: true,
                        date: selectedDate,
                        time: selectedTime24h,
                        treatment: formData.treatment,
                        name: formData.name,
                        pet_name: formData.pet_name,
                        species: formData.species,
                        contact_number: formData.contact_number
                    };

                    console.log('Datos a enviar:', appointmentData);

                    fetch('/api/createAppoinment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(appointmentData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Appointment creado correctamente') {
                            alert('Solicitud de cita enviada');
                            formData = {};
                            selectedDate = null;
                            selectedTime = null;
                            appointmentForm.reset();
                            calendarWidget.style.display = 'none';
                            formWidget.style.display = 'block';
                        } else {
                            alert('Error al realizar la solicitud: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al procesar la solicitud');
                    });
                });

                prevMonth.addEventListener('click', () => {
                    const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1);
                    if (newDate.getMonth() < new Date().getMonth() && 
                        newDate.getFullYear() <= new Date().getFullYear()) {
                        return;
                    }
                    document.querySelectorAll('.time-slot').forEach(slot => {
                        slot.classList.remove('selected');
                    });
                    selectedTime = null;
                    selectedTime24h = null;
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    updateCalendar();
                    updateTimeSlots();
                });

                nextMonth.addEventListener('click', () => {
                    document.querySelectorAll('.time-slot').forEach(slot => {
                        slot.classList.remove('selected');
                    });
                    selectedTime = null;
                    selectedTime24h = null;
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    updateCalendar();
                    updateTimeSlots();
                });

                generateTimeSlots();
                updateCalendar();
            });
        </script>
       
        <!-- END SCRIPTS -->

    </body>
    <script src="{{ asset('/js/assets/main.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/tabulator-tables/js/tabulator.min.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
    <script src="{{ asset('/js/assets/switch.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('/js/assets/libs/preline/preline.js') }}"></script>

</html>