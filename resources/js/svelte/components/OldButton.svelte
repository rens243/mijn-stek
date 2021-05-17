<script>
    import { createEventDispatcher  } from 'svelte'

    let spanClass 
    export { spanClass as class}

    const dispatch = createEventDispatcher()
    const forwardClick = (event) => dispatch('click', event.detail)
</script>

<span class="cursor-pointer text-center border-2 border-ridge bg-gray-300 active:bg-gray-500 my-1 p-0 leading-none {spanClass}" on:click={forwardClick}>
    <slot></slot>
</span>