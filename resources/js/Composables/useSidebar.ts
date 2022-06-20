import {ref} from 'vue'
import type {Ref} from 'vue'

const show: Ref<boolean> = ref(false)

export default () => {

    function showSidebar() {
        show.value = true
    }

    function hideSidebar() {
        show.value = false
    }

    return {show, showSidebar, hideSidebar}
}