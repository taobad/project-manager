<p class="text-center m-2">Select a CSV File to Upload</p>

<input type="hidden" name="header" value="1">

<div class="flex w-full h-45 items-center justify-center">
    <label
        class="w-64 flex flex-col items-center px-4 py-6 bg-white text-indigo-600 rounded-lg shadow-lg tracking-wide uppercase border border-indigo-500 cursor-pointer hover:bg-indigo-400 hover:text-white">
        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path
                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
        </svg>
        <span class="mt-2 text-base leading-normal">Select a file</span>
        <input type='file' id="file" onchange="javascript:updateList()" name="csvfile" class="hidden"
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            required />
    </label>
</div>