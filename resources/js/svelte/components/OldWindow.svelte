<script>
    import {tick} from 'svelte'
    import { tweened } from 'svelte/motion'
    import { slide } from 'svelte/transition';
    import OldButton from './OldButton.svelte'
    import { activeWindow } from '../store.js'
    import { createEventDispatcher } from 'svelte';
    import MdHtml from './MdHtml.svelte';

    // Initial values
    // TODO: typescript this
    export let title =  ''
    export let id = title
    export let titleColorFrom = 'from-red-600'
    export let titleColorTo = 'to-red-600'
    export let color = 'bg-gray-300'
    export let status = 'open' // collapsed, open, minimized
    export let isScrollable = false
    export let width = null
    export let height = null
    export let x = 0
    export let y = 0
    export let content = null
    export let md = null

    // Set isActive and put in store
    export let isActive = false
    if (isActive) $activeWindow = id
    $: isActive = $activeWindow == id 

    // Set magic numbers and variables....
    let windowElement 
    const minWidth = 150
    const minHeight = 36

    const dispatch = createEventDispatcher();

    // Smooth height change
    let tweenedHeight = tweened(height, {duration: 200});
    $: $tweenedHeight = height
    // setTimeout(() => height = windowElement.offsetHeight, 1000) // TODO: ewwww

    // Toggle collapsed
    let lastOpenHeight = null
    const toggleCollapsed = () => {
        if (status == 'open') collapse()
        else if (status == 'collapsed') open()  
    }
    const open = () => {
        height = lastOpenHeight
        status = 'open'
    }
    const collapse = () => {
        lastOpenHeight = windowElement.offsetHeight
        height = minHeight
        status = 'collapsed'
    }

</script>


<div
    class="absolute font-mono border-ridge border-4 {color} shadow-xl overflow-hidden flex flex-col text-left" 
    class:resize="{status !== 'collapsed' && isScrollable}"
    bind:this={windowElement} 
    transition:slide
    style="min-height: {minHeight || height}px; min-width: {minWidth || width}px; width: {width}px; height: {$tweenedHeight}px; top: {y}px; left: {x}px; z-index: {isActive ? 10 : 1};">
    <div 
        class="select-none bg-gradient-to-r {titleColorFrom} {titleColorTo} text-black pl-2 pr-1 flex flex-nowrap flex-row items-center cursor-move"
        on:mousedown="{(e) => dispatch('dragStart', {id: id, mouseEvent: e})}"
    >
        <span class="text-white flex-grow whitespace-nowrap"> {title} </span>

        <!-- <OldButton on:click="{() => y = y + 100}"class="ml-1 h-5 w-5 flex-shrink-0">
            ―
        </OldButton> -->

        {#if (process.env.NODE_ENV == 'dev')}
            <span class="whitespace-nowrap">{isActive} x:{x} y:{y} w:{width} h:{height}</span>
        {/if}

        <OldButton on:click="{toggleCollapsed}" class="ml-1 h-5 w-5 flex-shrink-0">
            {status === 'collapsed' ? '↓' : '↑'}
        </OldButton>

        <!-- <span class="cursor-pointer text-center border-2 border-ridge bg-gray-300 my-1 h-5 w-5 p-0 leading-none ml-1 flex-shrink-0">X</span> -->
    </div>
    <div class="flex-grow p-2 space-y-2" class:old-scroll="{isScrollable}">
        {#if (md)}
            <MdHtml file="{md}"></MdHtml>
        {/if}
        
        {#if (content)}
            {@html content}
        {/if}
        
        <slot></slot>
    </div>
</div>

<svelte:window on:mousemove="{(e) => dispatch('dragMove',{id: id, mouseEvent: e})}" on:mouseup={(e) => dispatch('dragEnd',{id: id, mouseEvent: e})}/>

<style>
    .old-scroll {
		overflow: scroll;
		scrollbar-color:  silver #e5e7eb;
		scrollbar-width: auto;
	}
</style>