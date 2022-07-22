<div>
    {{-- The Master doesn't talk, he acts. --}}

    <div class="text-sm font-thin">
        <p>Last Analysis: {{$latestDisplayMeasurementTime->longRelativeToNowDiffForHumans()}}</p>
        <p>Time: {{$latestDisplayMeasurementTime->toDayDateTimeString()}}</p>
        <p>Period: {{round($minutesAverage/60, 1)}} hours</p>
    </div>

    @php
      $lsi = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'LSI', 'calculation');
      $lsiValue = $lsi['values'][0];
      $imageFileName = 'LSI-Meter_';
      $sign = '';
      if($lsiValue < 0) $sign = 'n';
      $lsiValue = abs($lsiValue);
      $imageFileName .= $sign;
      if ($lsiValue <= 0.05){
          $imageFileName .= '0' . '.png';
      } else if ($lsiValue <= 0.11){
          $imageFileName .= '0.1' . '.png';
      } else if ($lsiValue <= 0.21){
          $imageFileName .= '0.2' . '.png';
      } else if ($lsiValue <= 0.31){
          $imageFileName .= '0.3' . '.png';
      } else if ($lsiValue <= 0.41){
          $imageFileName .= '0.4' . '.png';
      } else if ($lsiValue <= 0.51){
          $imageFileName .= '0.5' . '.png';
      } else if ($lsiValue <= 0.76){
          $imageFileName .= '0.75' . '.png';
      } else {
          $imageFileName .= '1.0' . '.png';
      }

    @endphp

    <div class="md:w-1/2 w-3/5 mx-auto flex justify-center">
{{--        <img  src="{{asset('images/meter/LSI-Meter_0.png')}}">--}}
        <img  src="{{asset('images/meter/'.$imageFileName)}}">
    </div>

    <div class="w-full">
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'LSI', 'calculation'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'free chlorine', 'colorimetric'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'total chlorine', 'colorimetric'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'ph', 'probe'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'temperature', 'probe'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'orp', 'probe'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'alkalinity', 'colorimetric'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>
        @php($m = \App\Models\Measurement::findInMetricsTable($metricsToDisplay, 'calcium', 'colorimetric'))
        <x-forms.field-display-only-mobile
            label="{{$m['metric']}}"
            value="{{round($m['values'][0], 3)}} {{$m['unit']}}"/>

    </div>
</div>
