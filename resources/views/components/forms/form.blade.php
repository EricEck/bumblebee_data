@props(['form_title' => '', 'reference_information'])

<div {{ $attributes->merge(['class' => "md:w-3/4 sm:w-full mx-auto md:my-2 md:py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg"])}}>

    <!-- Sub Container -->
    <div class="mx-auto md:px-6 ">

        <!--  Form Title -->
        <div {{$form_title->attributes->merge(['class' => "px-4 sm:px-0"])}}>
            <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $form_title }}</h3>
        </div>

        <!-- Form Container -->
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            {{$slot}}
        </div>

        <!-- optional further reference information -->
        <div {{isset($reference_information) ? $reference_information->attributes->merge(['class' => ""]) : ''}}>
            {{ $reference_information ?? '' }}
        </div>

    </div>
</div>
