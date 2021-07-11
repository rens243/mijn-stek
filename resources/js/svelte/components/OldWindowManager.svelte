<script>
	import { windowStore, activeWindow } from '../store'
	import OldWindow from './OldWindow.svelte'

	// export let name;
    export let list = []
    $windowStore = list

	let bgPosX = 0;
	let bgPosY = 0;

    const throttle = (func, limit = 16 ) => {
        let inThrottle;
        return (...args) => {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    const promisedThrottle = (func, limit = 16) => {
        let inThrottle;
        return (...args) => {
            const context = this
            return new Promise((resolve) => {
                if (!inThrottle) {
                    func.apply(context, args)
                    inThrottle = true
                    setTimeout(() => inThrottle = false, limit)
                    resolve()
                }
            })
        }
    }

	// Helper function to move windows
    const moveWindows = promisedThrottle((dX, dY) => {
        // Move windows
        $windowStore = windowStoreMap((oldWindow) => {
            oldWindow.x = oldWindow.x + dX
            oldWindow.y =  oldWindow.y + dY
            return oldWindow
        })
    })

    // Helper function to move background
    const moveBackground = promisedThrottle((dX, dY) => {
        bgPosX = bgPosX + dX
        bgPosY = bgPosY + dY
    })

	// Dragging logic
	let cursor = 'grab'
    let dragActive = false

    // Delta x and y when grabbing
    let dX = 0
    let dY = 0

    // Get last movement for inertia
    let inertiaDX = 0
    let inertiaDY = 0

    const dragStart = (e) => {
		cursor = 'grabbing'
        dragActive = true
    }
    const dragMove = (e) => {
        if (!dragActive) return

        dX += e.movementX
        dY += e.movementY

        Promise.all([
            moveWindows(dX, dY),
            moveBackground(dX, dY)
        ]).then(() => {
            inertiaDY = dY
            inertiaDX = dX

            dX = 0
            dY = 0
        })

    }
    const dragEnd = (e) => {
        if (dragActive) {
            // End drag
            dragActive = false
            cursor = 'grab'

            const inertiaDrag = (timestamp) => {
                // Stop inertia if drag is enabled again
                if (dragActive) return

                // No delta, nothing to move
                if (Math.abs(inertiaDX) < 0.1 && Math.abs(inertiaDY) < 0.1) return

                // Drag coefficient
                inertiaDX = inertiaDX * 0.95
                inertiaDY = inertiaDY * 0.95

                // Move all
                moveWindows(inertiaDX, inertiaDY)
                moveBackground(inertiaDX, inertiaDY)

                // 60fps animation loop.
                window.setTimeout(
                    () => window.requestAnimationFrame(inertiaDrag),
                    Math.max(0, 16 - Date.now() - timestamp)
                )
            }

            window.requestAnimationFrame(() => inertiaDrag(Date.now()))
        }

	    // End drag
		dragActive = false
		cursor = 'grab'
        dX = 0
        dY = 0
	}

	// Window drag logic
	let dragActiveWindow = null
	const dragStartWindow = (e) => {
        if (dragActiveWindow == null) dragActiveWindow = e.detail.id

		// Set current active
        $activeWindow = e.detail.id
    }
    const dragMoveWindow = (e) => {
		const currentId = e.detail.id
        if (dragActiveWindow !== currentId) return

		windowStoreMap((oldWindow) => {
			if (oldWindow.id === currentId) {
				// Add position difference to window
				oldWindow.y = oldWindow.y + e.detail.mouseEvent.movementY
				oldWindow.x = oldWindow.x + e.detail.mouseEvent.movementX
			}
			return oldWindow
		})
    }
    const dragEndWindow = (e) => dragActiveWindow = null

	const windowStoreMap = (mapF) => $windowStore = $windowStore.map(oldWindow => mapF(oldWindow))
</script>

<!-- all the fancy windows -->
{#each $windowStore as oldWindow}
	{#key oldWindow.id}
        <OldWindow {...oldWindow} on:dragStart="{dragStartWindow}" on:dragMove="{dragMoveWindow}"
                   on:dragEnd="{dragEndWindow}"/>
	{/key}
{/each}


<!-- actual background -->
<div id="main-bg" style="{`--bg-pos-y:${bgPosY};--bg-pos-x:${bgPosX}`}" class="cursor-{cursor}" on:mousedown="{dragStart}">
</div>
<svelte:body on:mousemove="{dragMove}" on:mouseleave="{dragEnd}" on:mouseup="{dragEnd}"/>

<style>
	#main-bg {
		width: 100%;
		height: 100%;
		background-size: 200px 200px;
		background-position-x: calc(var(--bg-pos-x, 0) * 1px);
		background-position-y: calc(var(--bg-pos-y, 0) * 1px);
		background-image: url("/media/star.png");
        filter: invert(54%) sepia(38%) saturate(6813%) hue-rotate(164deg) brightness(98%) contrast(103%);
	}

</style>
