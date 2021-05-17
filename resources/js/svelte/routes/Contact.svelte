<script>
    import { windowStore } from '../store.js'

    const getAge = (dateString) => {
		const today = new Date();
		const birthDate = new Date(dateString);
		let age = today.getFullYear() - birthDate.getFullYear();
		const m = today.getMonth() - birthDate.getMonth();
		if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
			age--;
		}
		return age;
	}

	const xMiddle = window.innerWidth / 2
	const yMiddle = window.innerHeight / 2

	$windowStore = [
        {
            title: 'email',
            width: 300,
            titleColorFrom:'from-blue-300',
			titleColorTo:'to-blue-300',
            x: xMiddle - 305,
			y: yMiddle - 150,
            content: "<p> Mijn e-mail is als volgt: het begint met 'rens'. Dan komt er een apenstaartje. En het eindigt met 'moring.nl'. Als dit te moeilijk is, dan ben je misschien een bot 🤖!"
        },
		{
            title: 'linkedin',
			titleColorFrom:'from-blue-300',
			titleColorTo:'to-blue-300',
			x: xMiddle + 5,
			y: yMiddle - 159,
			content: `
                <a href="https://www.linkedin.com/in/rens-moring/"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" class="global-nav__logo">
                        <title>LinkedIn</title>
                        <g>
                            <!----> <path d="M34,2.5v29A2.5,2.5,0,0,1,31.5,34H2.5A2.5,2.5,0,0,1,0,31.5V2.5A2.5,2.5,0,0,1,2.5,0h29A2.5,2.5,0,0,1,34,2.5ZM10,13H5V29h5Zm.45-5.5A2.88,2.88,0,0,0,7.59,4.6H7.5a2.9,2.9,0,0,0,0,5.8h0a2.88,2.88,0,0,0,2.95-2.81ZM29,19.28c0-4.81-3.06-6.68-6.1-6.68a5.7,5.7,0,0,0-5.06,2.58H17.7V13H13V29h5V20.49a3.32,3.32,0,0,1,3-3.58h.19c1.59,0,2.77,1,2.77,3.52V29h5Z" fill="currentColor"></path>
                        </g>
                    </svg>
                    <span> https://www.linkedin.com/in/rens-moring/ </span>
                </a>`
		},
		
	]
</script>
