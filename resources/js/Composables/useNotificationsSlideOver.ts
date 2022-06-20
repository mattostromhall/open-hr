import {ref} from 'vue'
import type {Ref} from 'vue'

const show: Ref<boolean> = ref(false)

export default () => {

    function showSlideOver() {
        show.value = true
    }

    function hideSlideOver() {
        show.value = false
    }

    return {show, showSlideOver, hideSlideOver}
}