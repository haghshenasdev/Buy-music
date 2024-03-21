<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <input wire:model.defer="{{ $getStatePath() }}" type="text" id="image_label" class="filament-forms-input block w-full rounded-lg shadow-sm outline-none transition duration-75 focus:ring-1 focus:ring-inset disabled:opacity-70 border-gray-300 focus:border-primary-500 focus:ring-primary-500" name="image"
           aria-label="Image" aria-describedby="button-image">
    <div class="input-group-append">
        <button onclick="window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" type="button" id="button-image">انتخاب / آپلود با فابل منیجر سایت</button>
    </div>

</x-dynamic-component>
