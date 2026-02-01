<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BAC Meeting Attendance Form</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3B82F6',
            secondary: '#1E40AF'
          },
          borderRadius: {
            'none': '0px',
            'sm': '4px',
            DEFAULT: '8px',
            'md': '12px',
            'lg': '16px',
            'xl': '20px',
            '2xl': '24px',
            '3xl': '32px',
            'full': '9999px',
            'button': '8px'
          },
          fontFamily: {
            'inter': ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>

  <style>
    /* --- Styles (same as your original) --- */
    .glass-morphism { background: rgba(255, 255, 255, 0.35); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.2) inset; }
    .floating-label { transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); font-weight: 500; }
    .floating-label.active { transform: translateY(-1.8rem) scale(0.85); color: #3B82F6; font-weight: 600; background: linear-gradient(to right, rgba(249, 250, 251, 0.95), rgba(255, 255, 255, 0.95), rgba(249, 250, 251, 0.95)); padding: 0 8px; border-radius: 4px; margin-left: -8px; backdrop-filter: blur(10px); }
    .enhanced-input { background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); border: 2px solid rgba(229,231,235,0.8); transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .enhanced-input:focus { border-color:#3B82F6; background: rgba(255,255,255,0.95); box-shadow: 0 0 0 3px rgba(59,130,246,0.1), 0 10px 15px -3px rgba(0,0,0,0.1); transform: translateY(-1px); outline:none; }
    .enhanced-button { background: linear-gradient(135deg,#3B82F6 0%,#1E40AF 100%); box-shadow: 0 10px 20px -5px rgba(59,130,246,0.4),0 0 0 1px rgba(255,255,255,0.1) inset; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.25,0.46,0.45,0.94); }
    .enhanced-button::before { content: ''; position: absolute; top:0; left:-100%; width:100%; height:100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition:left 0.6s ease; }
    .enhanced-button:hover::before { left:100%; }
    .enhanced-button:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 15px 30px -5px rgba(59,130,246,0.5),0 0 0 1px rgba(255,255,255,0.2) inset; }
    .enhanced-button:active { transform: translateY(0) scale(0.98); }
    .camera-preview { border:3px dashed #E5E7EB; background: rgba(249,250,251,0.8); backdrop-filter: blur(10px); position: relative; overflow:hidden; transition: all 0.4s; }
    .camera-preview.active { border-color: #3B82F6; background: rgba(59,130,246,0.08); box-shadow:0 0 0 1px rgba(59,130,246,0.1),0 10px 25px -5px rgba(59,130,246,0.1); }
    .camera-preview video, .camera-preview img { transform: scaleX(-1); border-radius:12px; box-shadow:0 10px 25px -5px rgba(0,0,0,0.1); }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 font-inter">
  <div class="min-h-screen flex flex-col">
    <header class="fade-in header-gradient text-white py-12 px-4 shadow-2xl relative overflow-hidden">
      <div class="max-w-4xl mx-auto text-center relative z-10">
        <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">BAC - MEETING and ISO</h1>
        <p class="text-xl text-blue-50 font-medium">Professional Attendance Registration System</p>
      </div>
    </header>

    <main class="flex-1 py-12 px-4">
      <div class="max-w-2xl mx-auto">
        <div class="slide-up glass-morphism rounded-3xl p-8 shadow-2xl">
          <form id="attendanceForm" action="/attendance" method="POST">
            @csrf
            <input type="hidden" name="photo" id="photo_input">
            <input type="hidden" name="type_attendee" id="type_attendee_input">

            <div class="space-y-6">
              <!-- Full Name -->
              <div class="relative group">
                <input type="text" id="fullName" name="fullName" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                <label for="fullName" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">Full Name</label>
              </div>

              <!-- Position -->
              <div class="relative group">
                <input type="text" id="position" name="position" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                <label for="position" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">Position/Title</label>
              </div>

              <!-- Attendee Type Dropdown -->
              <div class="relative">
                <button type="button" id="attendeeTypeBtn" class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-all duration-300 text-lg bg-white/80 backdrop-blur-sm text-left flex items-center justify-between">
                  <span id="selectedType" class="text-gray-500">Select Attendee Type</span>
                  <i class="ri-arrow-down-s-line text-xl transition-transform duration-300" id="dropdownIcon"></i>
                </button>
                <div id="attendeeDropdown" class="absolute top-full left-0 right-0 mt-2 bg-white/95 backdrop-blur-sm border-2 border-gray-200 rounded-xl shadow-lg opacity-0 invisible transition-all duration-300 z-50">
                  <div class="py-2">
                    <button type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC Member">BAC Member</button>
                    <button type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="BAC-TWG">BAC-TWG</button>
                    <button type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="Observers">Observers</button>
                    <button type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="End-User of the Province">End-User of the Province</button>
                    <button type="button" class="attendee-option w-full px-4 py-3 text-left hover:bg-primary/10 transition-colors duration-200" data-value="Supplier/Bidders">Supplier/Bidders</button>
                  </div>
                </div>
              </div>

              <!-- Phone Number -->
              <div class="relative group">
                <input type="text" name="phone_number" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                <label class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">Phone Number</label>
              </div>

              <!-- Attendance Date -->
              <div class="relative group">
                <input type="date" id="attendanceDate" name="attendance_date" required class="enhanced-input w-full pl-12 pr-4 py-4 rounded-2xl focus:outline-none text-lg font-medium">
                <label class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none text-lg">Date</label>
              </div>

              <!-- Photo Capture -->
              <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">Photo Capture</h3>
                <div class="camera-preview rounded-xl p-4 text-center min-h-[250px] flex flex-col items-center justify-center space-y-4">
                  <video id="cameraPreview" class="hidden w-full max-w-sm rounded-xl shadow-lg aspect-[4/3] object-cover bg-gray-100"></video>
                  <canvas id="photoCanvas" class="hidden"></canvas>
                  <img id="capturedPhoto" class="hidden w-full max-w-sm rounded-xl shadow-lg aspect-[4/3] object-cover">
                  <div id="cameraPlaceholder" class="flex flex-col items-center space-y-4">
                    <div class="w-16 h-16 flex items-center justify-center bg-gray-100 rounded-full">
                      <i class="ri-camera-line text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-base text-center">Tap to start camera and capture your photo</p>
                  </div>
                  <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full max-w-sm">
                    <button type="button" id="startCameraBtn" class="enhanced-button flex-1 px-4 py-3 text-white font-semibold flex items-center justify-center">
                      <i class="ri-camera-line text-lg mr-2"></i> Start Camera
                    </button>
                    <button type="button" id="captureBtn" class="enhanced-button flex-1 px-4 py-3 text-white font-semibold flex items-center justify-center hidden">
                      <i class="ri-camera-fill text-lg mr-2"></i> Capture Photo
                    </button>
                    <button type="button" id="retakeBtn" class="enhanced-button flex-1 px-4 py-3 text-white font-semibold flex items-center justify-center hidden">
                      <i class="ri-refresh-line text-lg mr-2"></i> Retake
                    </button>
                  </div>
                </div>
              </div>

              <button type="submit" class="enhanced-button w-full py-5 text-white text-xl font-bold rounded-2xl">
                Submit Attendance
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // --- FLOATING LABELS ---
      const inputs = document.querySelectorAll('input[type="text"], input[type="date"], input[type="time"], input[type="hidden"]');
      inputs.forEach(input => {
        const label = input.nextElementSibling;
        function updateLabel() {
          if (input.value || input === document.activeElement) label?.classList.add('active');
          else label?.classList.remove('active');
        }
        input.addEventListener('focus', updateLabel);
        input.addEventListener('blur', updateLabel);
        input.addEventListener('input', updateLabel);
        updateLabel();
      });

      // --- DROPDOWN ---
      const attendeeTypeBtn = document.getElementById('attendeeTypeBtn');
      const attendeeDropdown = document.getElementById('attendeeDropdown');
      const selectedType = document.getElementById('selectedType');
      const dropdownIcon = document.getElementById('dropdownIcon');
      const attendeeOptions = document.querySelectorAll('.attendee-option');
      const hiddenTypeInput = document.getElementById('type_attendee_input');
      let isOpen = false;

      attendeeTypeBtn.addEventListener('click', () => {
        isOpen = !isOpen;
        attendeeDropdown.classList.toggle('opacity-0', !isOpen);
        attendeeDropdown.classList.toggle('invisible', !isOpen);
        attendeeDropdown.classList.toggle('opacity-100', isOpen);
        attendeeDropdown.classList.toggle('visible', isOpen);
        dropdownIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
      });

      attendeeOptions.forEach(option => {
        option.addEventListener('click', function () {
          const value = this.dataset.value;
          selectedType.textContent = value;
          selectedType.classList.remove('text-gray-500');
          selectedType.classList.add('text-gray-800');
          hiddenTypeInput.value = value;

          attendeeDropdown.classList.add('opacity-0', 'invisible');
          attendeeDropdown.classList.remove('opacity-100', 'visible');
          dropdownIcon.style.transform = 'rotate(0deg)';
          isOpen = false;
        });
      });

      document.addEventListener('click', e => {
        if (!attendeeTypeBtn.contains(e.target) && !attendeeDropdown.contains(e.target)) {
          attendeeDropdown.classList.add('opacity-0', 'invisible');
          attendeeDropdown.classList.remove('opacity-100', 'visible');
          dropdownIcon.style.transform = 'rotate(0deg)';
          isOpen = false;
        }
      });

      // --- Camera ---
      const startCameraBtn = document.getElementById('startCameraBtn');
      const captureBtn = document.getElementById('captureBtn');
      const retakeBtn = document.getElementById('retakeBtn');
      const cameraPreview = document.getElementById('cameraPreview');
      const photoCanvas = document.getElementById('photoCanvas');
      const capturedPhoto = document.getElementById('capturedPhoto');
      const cameraPlaceholder = document.getElementById('cameraPlaceholder');
      const cameraContainer = document.querySelector('.camera-preview');
      const photoInput = document.getElementById('photo_input');
      let stream = null;

      startCameraBtn.addEventListener('click', async () => {
        try {
          stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
          cameraPreview.srcObject = stream;
          await cameraPreview.play();
          cameraPreview.classList.remove('hidden');
          cameraPlaceholder.classList.add('hidden');
          startCameraBtn.classList.add('hidden');
          captureBtn.classList.remove('hidden');
          cameraContainer.classList.add('active');
        } catch (err) {
          alert('Unable to access camera.');
        }
      });

      captureBtn.addEventListener('click', () => {
        const ctx = photoCanvas.getContext('2d');
        photoCanvas.width = cameraPreview.videoWidth;
        photoCanvas.height = cameraPreview.videoHeight;
        ctx.scale(-1, 1);
        ctx.drawImage(cameraPreview, -cameraPreview.videoWidth, 0);
        ctx.scale(-1, 1);

        capturedPhoto.src = photoCanvas.toDataURL('image/jpeg', 0.85);
        capturedPhoto.classList.remove('hidden');
        cameraPreview.classList.add('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
        if (stream) stream.getTracks().forEach(track => track.stop());
        photoInput.value = capturedPhoto.src;
      });

      retakeBtn.addEventListener('click', () => {
        capturedPhoto.src = '';
        capturedPhoto.classList.add('hidden');
        cameraPreview.classList.remove('hidden');
        retakeBtn.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
        photoInput.value = '';
      });

      // --- Default Date ---
      const dateInput = document.getElementById('attendanceDate');
      if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];

      // --- Form Submit ---
      const form = document.getElementById('attendanceForm');
      form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        if (!photoInput.value) {
          Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Please capture your photo!' });
          submitButton.disabled = false;
          submitButton.textContent = 'Submit Attendance';
          return;
        }

        try {
          const formData = new FormData(form);
          formData.set('attendance_time', new Date().toLocaleTimeString('en-US', { hour12: false }));

          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

          // --- HTTPS-safe fetch ---
          const response = await fetch(form.getAttribute('action'), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
          });

          const contentType = response.headers.get('content-type') || '';
          let result;
          if (contentType.includes('application/json')) {
            result = await response.json();
          } else {
            const text = await response.text();
            throw new Error('Server returned non-JSON response:\n' + text);
          }

          if (result.success) {
            Swal.fire({ icon: 'success', title: 'Success!', text: 'Attendance submitted successfully!', timer: 2000, showConfirmButton: false });
            form.reset();
            capturedPhoto.src = '';
            capturedPhoto.classList.add('hidden');
            cameraPreview.classList.add('hidden');
            cameraPlaceholder.classList.remove('hidden');
            startCameraBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            selectedType.textContent = 'Select Attendee Type';
            selectedType.classList.add('text-gray-500');
            selectedType.classList.remove('text-gray-800');
            photoInput.value = '';
          } else {
            let message = result.error || 'Unknown error';
            if (result.errors) {
              message += '\n\nValidation Errors:\n';
              for (const f in result.errors) message += `${f}: ${result.errors[f].join(', ')}\n`;
            }
            throw new Error(message);
          }
        } catch (err) {
          console.error(err);
          Swal.fire({ icon: 'error', title: 'Error!', text: err.message });
        } finally {
          submitButton.disabled = false;
          submitButton.textContent = 'Submit Attendance';
        }
      });

    });
  </script>
</body>
</html>
