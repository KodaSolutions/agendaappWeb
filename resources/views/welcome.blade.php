<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
 dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="light">
 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>{{ config('app.name', 'Inventorio') }}</title>

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
            <header class="app-header">
					<nav class="main-header" aria-label="Global">
						<div class="main-header-container !px-[0.85rem]">

						<div class="header-content-left">
							<div class="header-element !items-center">
							</div>
						</div>
						<div class="header-content-right">
							<!-- light and dark theme -->
							<div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] !px-[0.65rem]">
							<a aria-label="anchor"
								class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bodybg dark:hover:bg-black/20 dark:text-white/70 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
								href="javascript:void(0);" data-hs-theme-click-value="dark">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 -960 960 960"
								width="24">
								<path
									d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z" />
								</svg>
							</a>
							<a aria-label="anchor"
								class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg  dark:hover:bg-black/20 dark:text-white/70 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
								href="javascript:void(0);" data-hs-theme-click-value="light">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" fill="currentColor" height="24"
								viewBox="0 -960 960 960" width="24">
								<path
									d="M480-360q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0 80q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Zm326-268Z" />
								</svg>
							</a>
							</div>
							<!-- End light and dark theme -->
                            <!-- share button -->
							<div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] !px-[0.65rem]">
                                <a aria-label="anchor"
                                    class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bodybg dark:hover:bg-black/20 dark:text-white/70 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                    href="javascript:void(0);" data-hs-theme-click-value="dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.03-.47-.09-.7l7.05-4.11c.53.5 1.21.81 1.96.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.03.47.09.7L8.91 9.81c-.53-.5-1.21-.81-1.96-.81-1.66 0-3 1.34-3 3s1.34 3 3 3c.75 0 1.43-.31 1.96-.81l7.05 4.11c-.05.23-.09.46-.09.7 0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3z" />
                                    </svg>
                                </a>
                                <a aria-label="anchor"
                                    class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg  dark:hover:bg-black/20 dark:text-white/70 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                    href="javascript:void(0);" data-hs-theme-click-value="light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.03-.47-.09-.7l7.05-4.11c.53.5 1.21.81 1.96.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.03.47.09.7L8.91 9.81c-.53-.5-1.21-.81-1.96-.81-1.66 0-3 1.34-3 3s1.34 3 3 3c.75 0 1.43-.31 1.96-.81l7.05 4.11c-.05.23-.09.46-.09.7 0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3z" />
                                    </svg>
                                </a>
                            </div>
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
                  <div class="md:flex block items-center justify-between mb-6 mt-[2rem]  page-header-breadcrumb">
                    <div style="display: flex; align-items: center;">
                        <span class="avatar avatar-xxl avatar-rounded me-4">
                            <img src="{{asset('/css/assets/images/company-logos/8.png')}}" alt="">
                        </span>
                        <div class="my-auto">
                            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Clínica Veterinaria</h5>
                            <h5 class="page-title text-[1.3125rem] font-medium text-defaulttextcolor mb-0">Peninsular</h5>
                        </div>
                    </div>
                  </div>
                    <!-- Page Header Close -->

                    <!-- Start::row-1 -->
                    <div class="grid grid-cols-4 gap-x-6">
                        <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
                            <div class="box overflow-hidden">
                                <div class="box-body !p-0">
                                    <div class="sm:flex items-start !py-6 px-4 main-profile-cover">
                                        <div class="flex-grow main-profile-info">
                                            <div class="flex items-center !justify-between">
                                                <h5 class="font-semibold text-white" style="font-size: 1.5rem;">Agenda tu cita</h5>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 24 24" fill="white">
                                                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <form id="appointmentForm" class="grid grid-cols-12 sm:gap-x-6 sm:gap-y-4">
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Nombre del paciente (mascota)</label>
                                                <input type="text" name="pet_name" class="form-control placeholder:text-textmuted" 
                                                    placeholder="Nombre de la mascota" required>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Especie</label>
                                                <select name="species" class="form-control placeholder:text-textmuted" required>
                                                    <option value="">Seleccione una especie</option>
                                                    <option value="perro">Perro</option>
                                                    <option value="gato">Gato</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Nombre del propietario</label>
                                                <input type="text" name="name" class="form-control placeholder:text-textmuted" 
                                                    placeholder="Nombre completo del propietario" required>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Número de contacto</label>
                                                <input type="text" name="contact_number" class="form-control placeholder:text-textmuted" 
                                                    placeholder="Número de contacto" required>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Motivo de consulta</label>
                                                <textarea name="treatment" class="form-control placeholder:text-textmuted" 
                                                    placeholder="Describa el motivo de la consulta" required></textarea>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Fecha de cita</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-[#8c9097]"> <i class="ri-calendar-line"></i> </div>
                                                        <input type="date" name="date" class="form-control !border-s-0" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:col-span-6 col-span-12 mb-4">
                                                <label class="form-label">Hora de cita</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-[#8c9097]"> <i class="ri-time-line"></i> </div>
                                                        <input type="time" name="time" class="form-control !border-s-0" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:col-span-12 col-span-12 flex justify-center">
                                                <button type="submit" class="ti-btn ti-btn-primary-full !mb-1">Agendar cita</button>
                                            </div>
                                        </form>
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
    <script>
document.getElementById('appointmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const appointmentData = {
        client_id: 0,
        is_web: true, 
        date: formData.get('date'),
        time: formData.get('time'),
        treatment: formData.get('treatment'),
        name: formData.get('name'),
        pet_name: formData.get('pet_name'),
        species: formData.get('species'),
        contact_number: formData.get('contact_number')
    };

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
            alert('Cita agendada correctamente');
            this.reset();
        } else {
            alert('Error al agendar la cita: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
});
</script>
</html>