import {computed} from 'vue'
import type {ComputedRef} from 'vue'

export default (htmlString: unknown): ComputedRef<string> => {
    if (typeof htmlString !== 'string') {
        return computed(() => '')
    }

    return computed(() => htmlString.replace(/(<([^>]+)>)/gi, ''))
}