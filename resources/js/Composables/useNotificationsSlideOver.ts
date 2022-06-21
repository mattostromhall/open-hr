import {ref} from 'vue'
import type {Ref} from 'vue'

const show: Ref<boolean> = ref(false)

export default () => {

    function showNotifications() {
        show.value = true
    }

    function hideNotifications() {
        show.value = false
    }

    return {show, showNotifications, hideNotifications}
}