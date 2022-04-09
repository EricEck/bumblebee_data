@props([
'explanation' => '',
])



            </select>
        </div>
        @if(strlen($explanation) > 0)
            <div class="md:mt-0.5 sm:mt-0 sm:col-span-2 text-sm italic text-indigo-400 flex-wrap">
                {{$explanation}}
            </div>
        @endif
</div>
