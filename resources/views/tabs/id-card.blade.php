@extends('tabs.index')

@section('content')
<div class="max-w-md mx-auto mt-8 p-4 border rounded shadow-lg bg-gray-50">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-700">Select Student to Create ID Card</h2>

    <form action="{{ route('tabs.id-card') }}" method="GET">
        <label class="block mb-2 font-medium text-gray-700">Choose Student:</label>
        <select name="id" class="w-full border border-gray-300 px-3 py-2 rounded mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">-- Select Student --</option>
            @foreach($students as $studentOption)
                <option value="{{ $studentOption->id }}" {{ request('id') == $studentOption->id ? 'selected' : '' }}>
                    {{ $studentOption->full_name }} ({{ $studentOption->studentid }})
                </option>
            @endforeach
        </select>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-500 transition-colors">
            Create ID Card
        </button>
    </form>
</div>

@if(isset($student))
<div id="idCardSection" class="mt-8 w-80 mx-auto border border-gray-300 rounded-lg shadow-lg p-6 bg-white text-center relative font-sans">

    {{-- Card Header --}}
    <div class="bg-indigo-600 text-white py-2 rounded-t mb-4">
        <h2 class="text-lg font-bold">ENGINEERING MONK</h2>
    </div>

    {{-- Photo upload / preview --}}
    <div class="mb-4">
        <div id="photoPlaceholder" class="w-24 h-24 mx-auto rounded-full border-2 border-gray-300 bg-gray-100 flex items-center justify-center text-gray-400 text-sm mb-2">
            Photo
        </div>
        <div id="photoUploadDiv" class="mt-2">
            <input type="file" accept="image/*" id="photoInput" onchange="previewPhoto(event)" class="mx-auto block text-sm text-gray-600">
        </div>
    </div>

    {{-- ID Card fields --}}
   <div class="text-left space-y-1 px-2">
        <div class="flex">
            <span class="w-24 font-semibold">Name:</span>
            <span>{{ $student->full_name }}</span>
        </div>
        <div class="flex">
            <span class="w-24 font-semibold">Roll No:</span>
            <span>{{ $student->studentid }}</span>
        </div>
        <div class="flex">
            <span class="w-24 font-semibold">DOB:</span>
            <span>{{ $student->dob }}</span>
        </div>
        <div class="flex">
            <span class="w-24 font-semibold">Phone:</span>
            <span>{{ $student->whatsapp_number }}</span>
        </div>
        <div class="flex">
            <span class="w-24 font-semibold">Address:</span>
            <span class="whitespace-pre-line  text-right">{{ $student->address }}</span>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="mt-6 flex justify-between px-4">
        <button onclick="window.history.back()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500 transition-colors">
            ← Back
        </button>
        <button onclick="preparePrint()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500 transition-colors">
            Print Card
        </button>
    </div>
</div>
@endif

{{-- Tailwind --}}
<script src="https://cdn.tailwindcss.com"></script>

{{-- JS for photo preview and printing --}}
<script>
function previewPhoto(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let placeholder = document.getElementById('photoPlaceholder');
        placeholder.innerHTML = '';
        placeholder.style.backgroundImage = `url('${reader.result}')`;
        placeholder.style.backgroundSize = 'cover';
        placeholder.style.backgroundPosition = 'center';
        placeholder.style.border = 'none';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function preparePrint() {
    let photoInput = document.getElementById('photoInput');
    if (!photoInput.files.length) {
        alert("Please upload a photo before printing!");
        return;
    }
    printIdCard();
}

function printIdCard() {
    // Clone the ID card
    let cardContent = document.getElementById('idCardSection').cloneNode(true);

    // Remove buttons and file input
    cardContent.querySelectorAll('button, input').forEach(el => el.remove());

    // Replace placeholder with actual <img> keeping same size
    let placeholder = cardContent.querySelector('#photoPlaceholder');
    if (placeholder && placeholder.style.backgroundImage) {
        let img = document.createElement('img');
        img.src = placeholder.style.backgroundImage.replace(/url\(["']?/, '').replace(/["']?\)/, '');
        img.className = 'mx-auto w-24 h-24 rounded-full border-2 mb-2'; // exact same size as screen
        placeholder.innerHTML = '';
        placeholder.appendChild(img);
        placeholder.style.backgroundImage = '';
    }

    // Open print window
    let newWindow = window.open('', '', 'width=400,height=600');
    newWindow.document.write('<html><head><title>ID Card</title>');
    newWindow.document.write('<style>');
    newWindow.document.write(`
        body { font-family: sans-serif; margin:0; padding:20px; }
        .text-left { text-align: left; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .font-semibold { font-weight: 600; }
        .rounded-full { border-radius: 9999px; }
        .border { border: 1px solid #ccc; }
        .bg-indigo-600 { background-color: #4f46e5; color:white; padding:8px; text-align:center; font-weight:bold; border-radius:4px 4px 0 0; }
        .w-24 { width:6rem; }
        .h-24 { height:6rem; }
        .border-2 { border-width:2px; }
        .mb-2 { margin-bottom:0.5rem; }
        .mx-auto { margin-left:auto; margin-right:auto; }
    `);
    newWindow.document.write('</style></head><body>');
    newWindow.document.body.appendChild(cardContent);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}

</script>
@endsection
