const slug = 'all-embed-addons-for-elementor';

export const dashboardInfo = (info) => {
	const { version, isPremium, hasPro } = info;

	const proSuffix = isPremium ? ' Pro' : '';

	return {
		name: `All Embed${proSuffix}`,
		displayName: `All Embed${proSuffix} - Multi-Source Embed Widgets for Elementor.`,
		description: 'All Embed Addon for Elementor enhances your Elementor experience by allowing you to embed content from multiple platforms directly into your pages. Each widget is designed to be user-friendly, fully customizable, and responsive.',
		slug,
		logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`,
		banner: `https://ps.w.org/${slug}/assets/banner-772x250.png`,
		// video: 'https://www.youtube.com/watch?v=milYZrqLJsE',
		// isYoutube: true,
		version,
		isPremium,
		hasPro,
		pages: {
			org: `https://wordpress.org/plugins/${slug}/`,
			// landing: `https://bplugins.com/products/${slug}/`, //Learn More button aer jonno
			// docs: `https://bplugins.com/docs/${slug}/`,
			// pricing: `https://bplugins.com/products/${slug}/pricing`,
		},
		freemius: {
			product_id: 19836,
			plan_id: 32912,
			public_key: 'pk_a175d9d65767cc56ca88c39e031a9'
		}
	}
}

export const changelogs = [
	{
		version: '1.1.4',
		list: [
			'fixed Cross Site Scripting (XSS)'
		]
	},
	{
		version: '1.1.2',
		list: [
			'fixed deprecated error'
		]
	},
	{
		version: '1.0.0',
		list: [
			'Initaial release'
		]
	}
];

export const demoInfo = {
	title: 'Live Overview',
	description: 'Click on any style to view it live',
	allInOneLabel: 'See All Demo',
	allInOneLink: 'https://demo.bplugins.com/demo/',
	demos: [
		{
			icon: '',
			title: 'Linkedin Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-25-linkedin-embed/'
		},
		{
			icon: '',
			title: 'Facebook Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-23-facebook-embed/'
		},
		{
			icon: '',
			title: 'Pinterest Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-24-pinterest-embed/'
		},
		{
			icon: '',
			title: 'Kuula Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-22-kuula-embed/'
		},
		{
			icon: '',
			title: 'Sirv Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-20-sirv-embed/'
		},
		{
			icon: '',
			title: 'Mixcloud Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-21-mixcloud-player/'
		},
		{
			icon: '',
			title: 'Dartfish Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-17-dartfish-embed-player/'
		},
		{
			icon: '',
			title: 'Dailymotion Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-16-dailymotion-embed/'
		},
		{
			icon: '',
			title: 'Bandcamp Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-15-bandcamp-embed-player/'
		},
		{
			icon: '',
			title: 'Codepen Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-12-codepen-embed/'
		},
		{
			icon: '',
			title: 'Spotify Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-8-spotify-embed-player/'
		},
		{
			icon: '',
			title: 'Appointly Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-7-appointly-embed-player/'
		},
		{
			icon: '',
			title: 'Giphy Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-9-giphy-embed/'
		},
		{
			icon: '',
			title: 'YouTube Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-1-youtube-embed-player/'
		},
		{
			icon: '',
			title: 'Vimeo Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-2-vimeo-embed-player/'
		},
		{
			icon: '',
			title: 'Soundcloud Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-3-soundcloud-embed-player/'
		},
		{
			icon: '',
			title: 'JotForm Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-5-jotform-embed-form/'
		},
		{
			icon: '',
			title: 'Google Map Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://demo.bplugins.com/demo/demo-6-google-map-embed/'
		},
	]
}

export const pricingInfo = {
	cycles: [
		// {
		// 	cycle: 'monthly',
		// 	label: 'Monthly',
		// 	isDefault: false
		// },
		// {
		// 	cycle: 'annual',
		// 	label: 'Yearly',
		// 	isDefault: true
		// },
		{
			cycle: 'lifetime',
			label: 'Lifetime',
			isDefault: false
		}
	],
	plans: [
		{
			name: 'Single Site',
			quantity: 1,
			prices: {
				// monthly: '4.99',
				// annual: '47.88',
				lifetime: '29'
			},
			pricePrefix: '',
			priceSuffix: '',
			isFeatured: false,
			note: ''
		},
		{
			name: '3 Sites',
			quantity: 3,
			prices: {
				// monthly: '8.99',
				// annual: '83.88',
				lifetime: '79'
			},
			pricePrefix: '',
			priceSuffix: '',
			isFeatured: true,
			note: ''
		},
		{
			name: 'Unlimited Sites',
			quantity: 'null',
			prices: {
				// monthly: '33.99',
				// annual: '323.88',
				lifetime: '199'
			},
			pricePrefix: '',
			priceSuffix: '',
			isFeatured: false,
			note: ''
		}
	],
	features: [
		'Easily add videos from YouTube, Vimeo, Dailymotion, and Twitch.',
		'Share music or podcasts from SoundCloud, Spotify, Mixcloud, and Bandcamp.',
		'Integrate posts and profiles from Facebook, Twitter (TwitFrame), LinkedIn, Pinterest, and Reddit.',
		'Display prototypes, visuals, or resumes from InVision, Creddle, and Genially.',
		'Build and embed video/audio playlists anywhere in WordPress',
		'Embed CodePen snippets, SlideShare presentations, and Giphy animations.',
		'Showcase visuals from Imgur, Sirv, and Kuula for 360° or zoomable content.',
		'Add forms via JotForm or scheduling through Appointly.',
		'Display professional clips using Dartfish integration.',
		'Built with clean code to ensure minimal performance impact.'
	],
	button: {
		label: 'Buy Now ➜'
	},
	featured: {
		text: 'Best Value'
	}
}

export const filterDemoInfo = {
	categories: [
		{ label: 'All', value: 'all', col: 2, height: '19rem' },
		{ label: 'HTML5 Video Player', value: 'html-video-player', col: 1, height: '38rem' },
		{ label: 'Art Player', value: 'art-player', col: 1, height: '38rem' },
		{ label: 'dPlayer', value: 'dplayer', col: 1, height: '38rem' },
		{ label: 'YouTube Player', value: 'youtube-player', col: 1, height: '38rem' },
		{ label: 'Vimeo Player', value: 'vimeo-player', col: 1, height: '38rem' },
		{ label: 'Advance Video Player', value: 'advance-video-player', col: 1, height: '38rem' },
		{ label: 'Audio Player', value: 'audioplayer', col: 1, height: '38rem' },
		{ label: 'Playlist Player', value: 'playlist-player', col: 1, height: '38rem' }
	],
	demos: [
		{
			title: 'HTML5 Video Player',
			categories: ['html-video-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/html5-video-player.png'
		},
		{
			title: 'Art Player',
			categories: ['art-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/art-player.png'
		},
		{
			title: 'dPlayer',
			categories: ['dplayer'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/dplayer.png'
		},
		{
			title: 'YouTube Player',
			categories: ['youtube-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/youtube-player.png'
		},
		{
			title: 'Vimeo Player',
			categories: ['vimeo-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/vimeo-player.png'
		},
		{
			title: 'Advance Video Player ',
			categories: ['advance-video-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/advance-video-player.png'
		},
		{
			title: 'Audio Player ',
			categories: ['audioplayer'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/audio-player.png'
		},
		{
			title: 'Playlist Player(Audio & Video) ',
			categories: ['playlist-player'],
			url: 'https://templates.bplugins.com/wp-content/uploads/2025/09/playlist-player.png'
		},
	]
}


// export const featureCompareInfo = {
// 	title: 'Features',
// 	plans: [
// 		{
// 			id: 'ztbk4ex2fyi',
// 			name: 'Free Plan',
// 			color: '#485781'
// 		},
// 		{
// 			id: 'lhmjqhkeyi',
// 			name: `<span style='color: #485781;'>Pro Start from </span><span style='font-size: 1.3em;'>47.88/y</span>`,
// 			color: '#146EF5'
// 		}
// 	],
// 	features: [
// 		{
// 			label: 'Multiple Layouts (Grid, Masonry, Ticker, and Slider)',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Sub Layout (Left/Right Image, Overlay Box, Title Meta, and more)',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'More Layouts and Sub Layouts',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Customization for Post Ticker layout',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Shortcode to display the posts block anywhere',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Post Query (filter by post type, categories, author, post count, and order)',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Display Pages & Custom Post Types',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Advanced Filtering (filter by tag, taxonomy, author, and more)',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Post Offset (skip the first [n] posts)',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Include/Exclude Posts by IDs and Exclude Current Post',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Custom Post Query Hook',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Show/Hide Post Elements (feature image, title, metadata, excerpt, and read more button)',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Customize/Style Post Element (feature image, title, metadata, excerpt, and read more button)',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Fully Responsiveness for mobile, tablet, and desktop',
// 			plans: ['ztbk4ex2fyi', 'lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Customizable Pagination',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Rearrange/Sort post title and metadata',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Feature Image custom size',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Display Reading Time',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Show Excerpt from Main Content',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Enable/Disable Meta Author link',
// 			plans: ['lhmjqhkeyi']
// 		},
// 		{
// 			label: 'Custom Meta icons',
// 			plans: ['lhmjqhkeyi']
// 		}
// 	]
// }


const pluginSlug = slug;
const demoLink = 'https://bblockswp.com/demo';
const docsURL = 'https://bplugins.com/docs/bblocks';

export const blocksInfo = {
	title: 'All Widgets',
	action: 'bptbGetBlocks',
	blocks: [
		{
			name: `bae_youtube_addon`,
			title: 'YouTube Embeder',
			icon: '<svg viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="M36,72 L36,72 C55.882251,72 72,55.882251 72,36 L72,36 C72,16.117749 55.882251,-3.65231026e-15 36,0 L36,0 C16.117749,3.65231026e-15 -2.4348735e-15,16.117749 0,36 L0,36 C2.4348735e-15,55.882251 16.117749,72 36,72 Z" fill="#FF0002"></path> <path d="M31.044,42.269916 L31.0425,28.6877416 L44.0115,35.5022437 L31.044,42.269916 Z M59.52,26.3341627 C59.52,26.3341627 59.0505,23.003199 57.612,21.5363665 C55.7865,19.610299 53.7405,19.6012352 52.803,19.4894477 C46.086,19 36.0105,19 36.0105,19 L35.9895,19 C35.9895,19 25.914,19 19.197,19.4894477 C18.258,19.6012352 16.2135,19.610299 14.3865,21.5363665 C12.948,23.003199 12.48,26.3341627 12.48,26.3341627 C12.48,26.3341627 12,30.2467232 12,34.1577731 L12,37.8256098 C12,41.7381703 12.48,45.6492202 12.48,45.6492202 C12.48,45.6492202 12.948,48.9801839 14.3865,50.4470165 C16.2135,52.3730839 18.612,52.3126583 19.68,52.5135736 C23.52,52.8851913 36,53 36,53 C36,53 46.086,52.9848936 52.803,52.4954459 C53.7405,52.3821478 55.7865,52.3730839 57.612,50.4470165 C59.0505,48.9801839 59.52,45.6492202 59.52,45.6492202 C59.52,45.6492202 60,41.7381703 60,37.8256098 L60,34.1577731 C60,30.2467232 59.52,26.3341627 59.52,26.3341627 L59.52,26.3341627 Z" fill="#FFF"></path> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_vimeo_addon`,
			title: 'Vimeo Embeder',
			icon: '<svg viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="M36,72 L36,72 C55.882251,72 72,55.882251 72,36 L72,36 C72,16.117749 55.882251,-3.65231026e-15 36,0 L36,0 C16.117749,3.65231026e-15 -2.4348735e-15,16.117749 0,36 L0,36 C2.4348735e-15,55.882251 16.117749,72 36,72 Z" fill="#00B2EA"></path> <path d="M59.9758507,25.4793287 C59.7670024,30.1000139 56.4988081,36.4164401 50.193846,44.4314012 C43.6687465,52.8123295 38.13991,57 33.6214479,57 C30.8273957,57 28.4595071,54.4521978 26.5262488,49.3398315 C25.2308247,44.6493054 23.9438673,39.9587792 22.6512654,35.2822212 C21.2119052,30.1670613 19.6709431,27.6108782 18.0227346,27.6108782 C17.6643057,27.6108782 16.4140379,28.3567808 14.2578199,29.8513796 L12,26.971134 C14.3650664,24.9178065 16.6962654,22.8560982 18.9964194,20.7999771 C22.1460782,18.1013182 24.5139668,16.6849413 26.0944408,16.5368782 C29.8198436,16.179292 32.1171754,18.7019514 32.9836138,24.0964756 C33.9064976,29.9212207 34.5556209,33.5417817 34.9140498,34.9609523 C35.9921588,39.7883669 37.1718697,42.196487 38.4644716,42.196487 C39.4663792,42.196487 40.973474,40.6376343 42.9829337,37.5171354 C44.9923934,34.3910491 46.0620356,32.0164528 46.2087939,30.3793781 C46.4966659,27.6807192 45.4213792,26.3397707 42.9829337,26.3397707 C41.8342678,26.3397707 40.6489123,26.580024 39.4325119,27.0828797 C41.8032228,19.486965 46.3188626,15.7937693 52.9907204,16.0088798 C57.9325237,16.1457683 60.2665451,19.3081719 59.9758507,25.4793287" fill="#FFF"></path> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_soundcloud`,
			title: 'Sound Cloud Embeder',
			icon: '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="24" cy="24" r="20" fill="#FF8800"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.16 26.8651C13.21 26.8651 13.252 26.8244 13.2593 26.7677L13.5266 24.6598L13.2593 22.5045C13.2513 22.4472 13.21 22.4078 13.16 22.4078C13.1086 22.4078 13.0666 22.4485 13.0606 22.5052L12.824 24.6598L13.0606 26.7671C13.0673 26.8244 13.1086 26.8651 13.16 26.8651ZM12.2727 26.0638C12.3213 26.0638 12.3613 26.0251 12.3687 25.9704L12.5767 24.6598L12.3687 23.3265C12.3613 23.2712 12.322 23.2332 12.2727 23.2332C12.2227 23.2332 12.1827 23.2718 12.176 23.3272L12 24.6605L12.176 25.9704C12.1827 26.0258 12.2227 26.0638 12.2727 26.0638ZM14.2226 22.1032C14.2153 22.0352 14.1653 21.9859 14.1026 21.9859C14.0393 21.9859 13.9879 22.0352 13.9819 22.1032C13.9819 22.1039 13.7579 24.6605 13.7579 24.6605L13.9819 27.1237C13.9879 27.1931 14.0393 27.2417 14.1026 27.2417C14.1653 27.2417 14.2153 27.193 14.2226 27.1244L14.4779 24.6605L14.2226 22.1032ZM15.0533 27.3404C15.1266 27.3404 15.1873 27.2817 15.1939 27.2031L15.4339 24.6618L15.1939 22.0332C15.1873 21.9552 15.1266 21.8952 15.0533 21.8952C14.9786 21.8952 14.9186 21.9545 14.9126 22.0339L14.7013 24.6618L14.9126 27.2031C14.9186 27.2817 14.9786 27.3404 15.0533 27.3404ZM16.0112 27.3824C16.0972 27.3824 16.1666 27.3144 16.1732 27.2237L16.1726 27.2244L16.3999 24.6618L16.1726 22.2232C16.1666 22.1339 16.0972 22.0652 16.0112 22.0652C15.9252 22.0652 15.8566 22.1339 15.8506 22.2245L15.6512 24.6618L15.8506 27.2244C15.8559 27.3144 15.9252 27.3824 16.0112 27.3824ZM17.3712 24.6625L17.1599 20.6966C17.1539 20.5959 17.0745 20.5166 16.9785 20.5166C16.8812 20.5166 16.8012 20.5959 16.7972 20.6966L16.6099 24.6625L16.7972 27.225C16.8019 27.325 16.8819 27.4044 16.9785 27.4044C17.0752 27.4044 17.1545 27.3257 17.1599 27.2244V27.2257L17.3712 24.6625ZM17.9512 27.4084C18.0592 27.4084 18.1485 27.3204 18.1538 27.2084V27.2104L18.3518 24.6631L18.1538 19.7899C18.1485 19.6779 18.0592 19.5899 17.9512 19.5899C17.8425 19.5899 17.7538 19.6779 17.7492 19.7899C17.7492 19.7906 17.5732 24.6631 17.5732 24.6631L17.7492 27.209C17.7538 27.3204 17.8425 27.4084 17.9512 27.4084ZM18.9325 19.1633C18.8112 19.1633 18.7138 19.2606 18.7098 19.3846L18.5465 24.6631L18.7098 27.1837C18.7138 27.3064 18.8112 27.4037 18.9325 27.4037C19.0525 27.4037 19.1498 27.3064 19.1551 27.1824V27.1844L19.3385 24.6631L19.1551 19.3846C19.1505 19.2606 19.0525 19.1633 18.9325 19.1633ZM19.9218 27.4084C20.0538 27.4084 20.1611 27.3031 20.1651 27.1671V27.1684L20.3351 24.6638L20.1651 19.2066C20.1611 19.0706 20.0538 18.9646 19.9218 18.9646C19.7891 18.9646 19.6825 19.0706 19.6791 19.2066L19.5271 24.6638L19.6791 27.1684C19.6818 27.3031 19.7891 27.4084 19.9218 27.4084ZM20.9191 27.4057C21.0624 27.4057 21.1791 27.291 21.1824 27.1431V27.1457L21.3391 24.6631L21.1824 19.3453C21.1791 19.1986 21.0624 19.0833 20.9191 19.0833C20.7744 19.0833 20.6578 19.1986 20.6551 19.3459L20.5164 24.6631L20.6551 27.1444C20.6578 27.291 20.7744 27.4057 20.9191 27.4057ZM22.3504 24.6645L22.2071 19.5406C22.2037 19.3819 22.0791 19.2579 21.9231 19.2579C21.7671 19.2579 21.6417 19.3826 21.6384 19.5406L21.5124 24.6645L21.6384 27.1297C21.6417 27.2864 21.7664 27.411 21.9231 27.411C22.0784 27.411 22.2037 27.2864 22.2071 27.1284V27.1297L22.3504 24.6645ZM22.9364 27.4157C23.1004 27.4157 23.2377 27.2797 23.2397 27.1124V27.1144L23.3684 24.6651L23.2397 18.568C23.2377 18.4006 23.1004 18.264 22.9364 18.264C22.7704 18.264 22.6337 18.4006 22.6317 18.568L22.5164 24.6631C22.5164 24.6678 22.6317 27.1144 22.6317 27.1144C22.6337 27.2797 22.7704 27.4157 22.9364 27.4157ZM23.9443 17.692C23.7663 17.692 23.621 17.8373 23.619 18.016L23.4857 24.6658L23.619 27.0791C23.621 27.2557 23.767 27.4004 23.9443 27.4004C24.1203 27.4004 24.2663 27.255 24.2683 27.0771V27.0791L24.413 24.6658L24.2683 18.0153C24.2663 17.8366 24.1203 17.692 23.9443 17.692ZM24.8663 27.4177C24.8737 27.4184 32.9954 27.423 33.0481 27.423C34.678 27.423 36 26.1011 36 24.4705C36 22.8398 34.6787 21.5185 33.0481 21.5185C32.6441 21.5185 32.2581 21.6005 31.9068 21.7472C31.6721 19.0866 29.4409 17 26.7196 17C26.0536 17 25.405 17.1313 24.8317 17.3527C24.6083 17.4393 24.5497 17.528 24.5477 17.7V27.0691C24.5497 27.2497 24.689 27.3997 24.8663 27.4177Z" fill="white"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_invison`,
			title: 'Invision Emberder',
			icon: '<svg viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd"> <path d="M36,72 L36,72 C55.882251,72 72,55.882251 72,36 L72,36 C72,16.117749 55.882251,-3.65231026e-15 36,0 L36,0 C16.117749,3.65231026e-15 -2.4348735e-15,16.117749 0,36 L0,36 C2.4348735e-15,55.882251 16.117749,72 36,72 Z" fill="#FF2A63"></path> <path d="M24.0624545,22.6532727 C26.4559091,22.6532727 28.4607273,20.7771818 28.4607273,18.3185455 C28.4607273,15.8615455 26.4559091,13.986 24.0624545,13.986 C21.669,13.986 19.6644545,15.8615455 19.6644545,18.3185455 C19.6644545,20.7771818 21.669,22.6532727 24.0624545,22.6532727 L24.0624545,22.6532727 Z M14.9424545,45.8620909 C14.6841818,46.9617273 14.5543636,48.1491818 14.5543636,49.1179091 C14.5543636,52.9347273 16.6240909,55.4686364 21.0226364,55.4686364 C24.6706364,55.4686364 27.6278182,53.3020909 29.757,49.8043636 L28.4569091,55.0224545 L35.7005455,55.0224545 L39.8405455,38.4177273 C40.8752727,34.2133636 42.8803636,32.0312727 45.9207273,32.0312727 C48.3139091,32.0312727 49.8016364,33.5195455 49.8016364,35.9765455 C49.8016364,36.6886364 49.7367273,37.464 49.4781818,38.3050909 L47.3432727,45.9373636 C47.0198182,47.037 46.8910909,48.1374545 46.8910909,49.1713636 C46.8910909,52.7948182 49.0251818,55.4451818 53.4880909,55.4451818 C57.3043636,55.4451818 60.3441818,52.9884545 62.0260909,47.1021818 L59.1804545,46.0033636 C57.7570909,49.947 56.5281818,50.6599091 55.5580909,50.6599091 C54.5877273,50.6599091 54.0700909,50.0135455 54.0700909,48.7205455 C54.0700909,48.1385455 54.1999091,47.4924545 54.3935455,46.7146364 L56.4638182,39.2787273 C56.9809091,37.5327273 57.1753636,35.9844545 57.1753636,34.5619091 C57.1753636,28.9993636 53.8115455,26.0964545 49.7367273,26.0964545 C45.9207273,26.0964545 42.0395455,29.5385455 40.0996364,33.1611818 L41.5221818,26.6588182 L30.462,26.6588182 L28.9093636,32.3860909 L34.0840909,32.3860909 L30.8978182,45.1437273 C28.3952727,50.7062727 23.7987273,50.7965455 23.2219091,50.6672727 C22.2747273,50.4537273 21.669,50.094 21.669,48.8631818 C21.669,48.153 21.7982727,47.133 22.1217273,45.903 L26.9732727,26.6588182 L14.6841818,26.6588182 L13.1315455,32.3860909 L18.2410909,32.3860909 L14.9424545,45.8620909 L14.9424545,45.8620909 Z" fill="#FFF"></path> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_jotform`,
			title: 'JotForm Embeder',
			icon: '<svg fill="#000000" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="green" d="M4.2666667 5.73333l-.9333334.93334 3 3L13 3l-.933333-.93333L6.3333333 7.8 4.2666667 5.73333z"></path><path d="M11.666667 11.66667H2.3333333V2.33333H9V1H2.3333333C1.6 1 1 1.6 1 2.33333v9.33334C1 12.4 1.6 13 2.3333333 13h9.3333337C12.4 13 13 12.4 13 11.66667V6.33333h-1.333333v5.33334z"></path></g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_google_map`,
			title: 'Google Map Embeder',
			icon: '<svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#40A459;" cx="255.722" cy="256" r="255.445"></circle> <path style="fill:#378B4E;" d="M255.722,0.555c-1.944,0-3.878,0.03-5.812,0.073c-0.492,0.011-0.983,0.022-1.474,0.037 c-1.843,0.051-3.682,0.119-5.514,0.209c-0.474,0.023-0.945,0.056-1.418,0.081c-1.394,0.077-2.785,0.165-4.174,0.264 c-0.699,0.05-1.397,0.098-2.094,0.153c-1.61,0.128-3.217,0.27-4.82,0.428c-0.829,0.082-1.654,0.173-2.479,0.262 c-0.991,0.108-1.98,0.221-2.968,0.34c-0.856,0.103-1.714,0.202-2.567,0.313c125.334,16.327,222.126,123.498,222.126,253.282 S347.737,492.953,222.403,509.28c0.854,0.111,1.71,0.211,2.567,0.313c0.987,0.119,1.977,0.232,2.968,0.34 c0.826,0.09,1.652,0.181,2.479,0.262c1.603,0.158,3.209,0.3,4.82,0.428c0.696,0.056,1.395,0.104,2.094,0.153 c1.388,0.099,2.779,0.188,4.174,0.264c0.473,0.027,0.945,0.058,1.418,0.081c1.833,0.09,3.672,0.158,5.514,0.209 c0.491,0.014,0.982,0.026,1.474,0.037c1.932,0.043,3.868,0.073,5.812,0.073c141.079,0,255.445-114.367,255.445-255.445 S396.801,0.555,255.722,0.555z"></path> <path style="fill:#898790;" d="M222.403,233.787l106.563-61.152c0,0,116.569,24.829,143.473-24.263l8.485-15.483l7.379,16.04 c15.321,33.304,23.42,70.329,23.42,107.071c0,84.691-41.95,163.833-112.217,211.703l-7.25,4.94L222.403,233.787z"></path> <path style="fill:#7A797F;" d="M511.166,256c0-44.143-11.198-85.671-30.908-121.898l-7.82,14.269 c-9.45,17.245-21.888,34.878-34.284,50.741c4.162,18.295,6.374,37.333,6.374,56.888c0,71.337-29.248,135.834-76.4,182.176 l23.852,34.666C463.639,427.598,511.166,347.012,511.166,256z"></path> <path style="fill:#3D9AE3;" d="M255.722,512c-87.455,0-168.01-44.081-215.484-117.917l-4.527-7.04l142.267-119.937l163.74,230.122 l-10.434,3.385C306.874,508.169,281.452,512,255.722,512z"></path> <path style="fill:#1D81CE;" d="M342.752,496.827l-17.317-24.795c-30.569,19.333-65.625,32.915-103.137,37.801 c10.906,1.42,22.13,1.612,33.424,1.612C286.17,511.445,315.674,506.6,342.752,496.827z"></path> <path style="fill:#FFFFFF;" d="M177.978,267.106l44.425-33.319l170.805,238.278l-8.302,4.872 c-11.729,6.884-24.073,12.861-36.69,17.766l-6.499,2.527L177.978,267.106z"></path> <path style="fill:#E0E0E3;" d="M341.718,497.229c18.2-6.475,35.457-14.944,51.49-25.164l-24.615-34.338 c-13.395,13.232-28.248,24.992-44.293,35.023L341.718,497.229z"></path> <path style="fill:#FFCE00;" d="M31.37,379.188c-7.01-12.718-12.964-26.113-17.696-39.813l-2.112-8.059l299.691-208.592 l44.425,33.319L35.712,387.042L31.37,379.188z"></path> <path style="fill:#CD2900;" d="M382.579,250.216c-15.713-16.41-94.094-100.753-94.094-149.704C288.485,45.089,333.575,0,388.997,0 s100.512,45.089,100.512,100.512c0,48.918-78.382,133.287-94.095,149.704l0,0C391.917,253.87,386.077,253.871,382.579,250.216 L382.579,250.216z"></path> <path style="fill:#891D00;" d="M388.997,134.386c-24.803,0-44.98-20.178-44.98-44.98s20.178-44.98,44.98-44.98 c24.803,0,44.98,20.178,44.98,44.98S413.8,134.386,388.997,134.386z"></path> <path style="fill:#FFFFFF;" d="M144.659,186.586c29.088,0,52.755-23.666,52.755-52.755c0-4.6-3.729-8.33-8.33-8.33h-33.319 c-4.6,0-8.33,3.729-8.33,8.33c0,4.6,3.729,8.33,8.33,8.33h24.018c-3.769,15.901-18.088,27.766-35.125,27.766 c-19.902,0-36.095-16.193-36.095-36.095s16.193-36.095,36.095-36.095c8.8,0,17.275,3.202,23.865,9.015 c3.452,3.044,8.715,2.713,11.757-0.736c3.043-3.45,2.713-8.714-0.736-11.757c-9.636-8.5-22.025-13.181-34.886-13.181 c-29.088,0-52.755,23.666-52.755,52.755S115.57,186.586,144.659,186.586z"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_appointly`,
			title: 'Appointly Embeder',
			icon: '<svg viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M111.42 113.34H16.58a4.88 4.88 0 0 1-4.88-4.88V42.03c0-7.27 5.65-13.16 12.62-13.16h79.37c6.97 0 12.62 5.89 12.62 13.16V108.46c0 2.7-2.19 4.88-4.89 4.88z" fill="#fafafa" stroke="#bdbdbd" stroke-width="3" stroke-miterlimit="10"> </path> <path d="M112.11 4h-4.8c-1 0-1.81.81-1.81 1.81V9.9c0 .67.38 1.25.95 1.6c2.01 1.2 3.24 3.57 2.71 6.17c-.45 2.2-2.21 3.98-4.41 4.44a5.788 5.788 0 0 1-7.03-5.65c0-2.12 1.14-3.97 2.85-4.97c.57-.34.94-.92.94-1.58v-4.1c0-1-.81-1.81-1.81-1.81H28.27c-.98 0-1.77.79-1.77 1.77v4.16c0 .65.37 1.22.93 1.55a5.783 5.783 0 0 1 2.73 6.18c-.45 2.2-2.21 3.98-4.41 4.44a5.788 5.788 0 0 1-7.03-5.65c0-2.13 1.16-3.98 2.87-4.99c.55-.32.91-.9.91-1.54V5.77c0-.98-.79-1.77-1.77-1.77h-4.85a5.75 5.75 0 0 0-5.75 5.75v37.52H117.7l.16-37.49A5.745 5.745 0 0 0 112.11 4z" fill="#f44336"> </path> <g fill="#ffffff"> <path d="M45.09 15.46h4.12V29.3c0 1.27-.28 2.4-.84 3.37s-1.36 1.73-2.38 2.26c-1.03.53-2.18.8-3.47.8c-2.11 0-3.76-.54-4.94-1.61c-1.18-1.07-1.77-2.6-1.77-4.56h4.15c0 .98.21 1.7.62 2.17c.41.47 1.06.7 1.95.7c.79 0 1.41-.27 1.88-.81s.7-1.31.7-2.31V15.46z"> </path> <path d="M61.37 33.94c-.98 1.19-2.33 1.78-4.06 1.78c-1.59 0-2.81-.46-3.64-1.37c-.84-.91-1.27-2.26-1.28-4.02V20.6h3.97v9.61c0 1.55.7 2.32 2.11 2.32c1.35 0 2.27-.47 2.77-1.4V20.6h3.98v14.85h-3.73l-.12-1.51z"> </path> <path d="M72.39 35.45h-3.98V14.37h3.98v21.08z"> </path> <path d="M81.2 29.83l2.75-9.24h4.26l-5.97 17.16l-.33.78c-.89 1.94-2.35 2.91-4.39 2.91c-.58 0-1.16-.09-1.76-.26v-3.01l.6.01c.75 0 1.31-.11 1.68-.34c.37-.23.66-.61.87-1.14l.47-1.22l-5.2-14.89h4.27l2.75 9.24z"> </path> </g> <path d="M53.22 102.31h-8.57V69.26l-10.24 3.17v-6.97l17.89-6.41h.92v43.26z" fill="#000000"> </path> <path d="M93.59 63.9l-16.7 38.41h-9.05l16.73-36.28H63.09v-6.91h30.5v4.78z" fill="#000000"> </path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_spotify`,
			title: 'Spotify Embeder',
			icon: '<svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#50B95D;" cx="256" cy="256" r="256"></circle> <path style="fill:#20A83E;" d="M34.133,256c0-135.648,105.508-246.636,238.933-255.42C267.424,0.208,261.737,0,256,0 C114.615,0,0,114.615,0,256s114.615,256,256,256c5.737,0,11.424-0.208,17.067-0.58C139.642,502.636,34.133,391.648,34.133,256z"></path> <g> <path style="fill:#FFFFFF;" d="M358.23,335.212L358.23,335.212c-48.438-21.419-100.06-32.278-153.43-32.278 c-31.435,0-62.695,3.854-92.913,11.454c-11.408,2.869-18.355,14.485-15.485,25.893c2.869,11.406,14.483,18.353,25.893,15.485 c26.816-6.746,54.575-10.165,82.506-10.165c47.392,0,93.207,9.634,136.176,28.635c8.213,3.631,18.391,1.478,24.423-5.178 c5.613-6.194,6.945-15.57,3.569-23.173C366.867,341.153,362.961,337.303,358.23,335.212z"></path> <path style="fill:#FFFFFF;" d="M386.652,259.147c-57.538-24.737-118.722-37.28-181.852-37.28c-31.25,0-62.486,3.15-92.839,9.361 c-13.662,2.796-22.749,16.529-19.949,30.212c2.829,13.822,16.377,22.777,30.212,19.948c26.986-5.521,54.768-8.321,82.576-8.321 c56.134,0,110.515,11.142,161.63,33.118c9.554,4.107,21.119,1.799,28.405-5.61c7.328-7.452,9.173-19.09,4.917-28.574 C397.177,266.262,392.429,261.631,386.652,259.147z"></path> <path style="fill:#FFFFFF;" d="M444.853,196.524c-2.849-7.452-8.429-13.348-15.712-16.603 C358.38,148.3,282.901,132.267,204.8,132.267c-36.37,0-72.745,3.573-108.113,10.621c-11.318,2.255-20.645,11.296-23.27,22.532 c-2.902,12.42,2.736,25.532,13.526,32.211c6.365,3.94,14.074,5.305,21.417,3.838C139.894,195.186,172.341,192,204.8,192 c69.648,0,136.928,14.285,199.971,42.457c8.618,3.852,18.891,3.334,27.07-1.381c7.268-4.191,12.572-11.468,14.337-19.669 C447.383,207.802,446.899,201.874,444.853,196.524z"></path> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_giphy`,
			title: 'Giphy Embeder',
			icon: '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48"><path fill="#212121" fill-rule="evenodd" d="M8,4h24v4h4v4h4v32H8V4z" clip-rule="evenodd"></path><path fill="#69f0ae" d="M8,8h4v32H8V8z"></path><path fill="#7e57c2" d="M36,16h4v24h-4V16z"></path><path fill="#00e5ff" d="M8,40h32v4H8V40z"></path><path fill="#ffee58" d="M8,4h20v4H8V4z"></path><path fill="#ef5350" d="M36,12V8h-4V4h-4v12h12v-4"></path><path fill="#512da8" d="M36,20v-4h4"></path><path fill="#9e9d24" fill-rule="evenodd" d="M28,4v4h-4" clip-rule="evenodd"></path></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_imgur`,
			title: 'Imgur Embeder',
			icon: '<svg viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-disc-upload" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>598</title> <defs> </defs> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g fill="#434343"> <path d="M7.917,6 C6.857,6 6,6.863 6,7.93 C6,8.995 6.857,9.858 7.917,9.858 C8.974,9.858 9.832,8.996 9.832,7.93 C9.832,6.864 8.974,6 7.917,6 L7.917,6 Z" class="si-glyph-fill"> </path> <path d="M10.979,15.1106614 L14.51,10.5030985 L15.2,11.4045782 C15.702,10.3553813 15.999,9.18983179 15.999,7.94637663 C15.999,3.49867206 12.417,0 7.999,0 C3.581,0 -0.00100000005,3.49867206 -0.00100000005,7.94637663 C-0.00100000005,12.3940812 3.581,16 7.999,16 C9.366,16 10.642,15.7005185 11.765,15.1106614 L10.979,15.1106614 L10.979,15.1106614 Z M12.423,2.691 L13.269,3.537 L11.481,5.324 L10.637,4.479 L12.423,2.691 L12.423,2.691 Z M3.548,13.258 L2.703,12.412 L4.49,10.625 L5.336,11.47 L3.548,13.258 L3.548,13.258 Z M8,11 C6.34408936,11 5,9.65704979 5,8.00046533 C5,6.34388087 6.34315855,5 8,5 C9.65684145,5 11,6.34295021 11,8.00046533 C11,9.65611913 9.65591064,11 8,11 L8,11 Z" class="si-glyph-fill"> </path> <path d="M16,13.966 L14.511,12.106 L13.021,13.966 L14.018,13.966 L14.018,15.969 L14.988,15.969 L14.988,13.966 L16,13.966 Z" class="si-glyph-fill"> </path> </g> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_slideshare`,
			title: 'Slide Share Embeder',
			icon: '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect> <path d="M4 8H44" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 8H40V34H8L8 8Z" fill="#2F88FF" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M22 16L27 21L22 26" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16 42L24 34L32 42" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_codepen`,
			title: 'Codepen Embeder',
			icon: '<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="16" cy="16" r="14" fill="#000000"></circle> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4453 6.16795C15.7812 5.94402 16.2188 5.94402 16.5547 6.16795L25.5547 12.1679C25.8329 12.3534 26 12.6656 26 13V19C26 19.3344 25.8329 19.6466 25.5547 19.8321L16.5547 25.8321C16.2188 26.056 15.7812 26.056 15.4453 25.8321L6.4453 19.8321C6.1671 19.6466 6 19.3344 6 19V13C6 12.6656 6.1671 12.3534 6.4453 12.1679L15.4453 6.16795ZM8 14.8685L9.69722 16L8 17.1315V14.8685ZM8.80278 19L15 23.1315V19.5352L11.5 17.2018L8.80278 19ZM13.3028 16L16 17.7982L18.6972 16L16 14.2018L13.3028 16ZM17 12.4648L20.5 14.7981L23.1972 13L17 8.86852V12.4648ZM15 8.86852V12.4648L11.5 14.7981L8.80278 13L15 8.86852ZM24 14.8685L22.3028 16L24 17.1315V14.8685ZM23.1972 19L20.5 17.2019L17 19.5352V23.1315L23.1972 19Z" fill="white"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_twitch`,
			title: 'Twitch Embeder',
			icon: '<svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="512" cy="512" r="512" style="fill:#9146ff"></circle> <path d="M692.9 535 617 607h-76l-66.5 63v-63H389V337.2h303.9V535zM370 301.2l-95 89.9v323.8h114v89.9l95-89.9h76L730.9 553V301.2H370zM636 403h-38v107.9h38V403zm-142.5-.5h38v107.9h-38V402.5z" style="fill:#fff"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_twitframe`,
			title: 'Twitframe Embeder',
			icon: '<svg fill="#000000" viewBox="0 0 24 24" id="twitter-square" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><line id="secondary" x1="10" y1="11" x2="13" y2="11" style="fill: none; stroke: #2ca9bc; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></line><path id="secondary-2" data-name="secondary" d="M10,7v8a2,2,0,0,0,2,2h2" style="fill: none; stroke: #2ca9bc; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><rect id="primary" x="3" y="3" width="18" height="18" rx="1" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></rect></g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_bandcamp`,
			title: 'Bandcamp Embeder',
			icon: '<svg fill="#000000" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M 7,1 C 3.6854839,1 1,3.68548 1,7 c 0,3.31452 2.6854839,6 6,6 3.314516,0 6,-2.68548 6,-6 C 13,3.68548 10.314516,1 7,1 Z m 1.166129,7.88952 -4.3790322,0 2.0491935,-3.77662 4.3790327,0 -2.049194,3.77662 z"></path></g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_dailymotion`,
			title: 'Daily Motion Embeder',
			icon: '<svg viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Dailymotion-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-400.000000, -361.000000)" fill="#0066DC"> <path d="M400,409 L448,409 L448,361 L400,361 L400,409 Z M441.390625,402.565422 L434.236141,402.565422 L434.236141,399.759719 C432.038406,401.910766 429.793797,402.705719 426.801063,402.705719 C423.761547,402.705719 421.142875,401.723734 418.945047,399.759719 C416.045781,397.187875 414.549484,393.821031 414.549484,389.893047 C414.549484,386.292344 415.952406,383.065844 418.570984,380.540687 C420.909109,378.249391 423.761547,377.080375 426.941359,377.080375 C429.980875,377.080375 432.318953,378.109094 434.002375,380.260094 L434.002375,369.317875 L441.390625,367.787031 L441.390625,402.565422 Z M428.157203,383.626984 C424.650016,383.626984 421.937875,386.479422 421.937875,389.846266 C421.937875,393.353453 424.650016,396.018813 428.43775,396.018813 C431.617563,396.018813 434.282922,393.400188 434.282922,389.939781 C434.282922,386.339172 431.617563,383.626984 428.157203,383.626984 Z" id="Dailymotion"> </path> </g> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_dartfish`,
			title: 'Dartfish Embeder',
			icon: '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 398.489 398.489" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path style="fill:#005FAD;" d="M0,283.067c0,12.795,10.468,23.262,23.261,23.262h290.961c12.794,0,23.262-10.467,23.262-23.262 V80.889c0-12.793-10.468-23.262-23.262-23.262H23.261C10.468,57.627,0,68.096,0,80.889V283.067z"></path> </g> <path style="fill:#0071CE;" d="M344.504,283.067c0,12.795-10.467,23.262-23.262,23.262H30.282 c-12.794,0-23.262-10.467-23.262-23.262V80.889c0-12.793,10.468-23.262,23.262-23.262h290.96c12.795,0,23.262,10.469,23.262,23.262 V283.067z"></path> <g> <circle style="fill:#FFFFFF;" cx="175.741" cy="181.978" r="81.734"></circle> <path style="fill:#1E252B;" d="M164.226,220.535c-7.449,4.819-13.543,1.503-13.543-7.368v-62.376 c0-8.873,6.095-12.189,13.543-7.371l46.043,29.793c7.45,4.82,7.45,12.709,0,17.527L164.226,220.535z"></path> </g> <g> <rect x="270.251" y="149.124" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 329.7993 627.564)" style="fill:#1E252B;" width="49.244" height="192.709"></rect> <path style="fill:#5C6670;" d="M329.464,221.394c-2.896,2.895-7.591,2.895-10.485,0c-2.896-2.895-2.896-7.591,0-10.485 l20.206-20.207c2.895-2.895,7.591-2.895,10.485,0c2.896,2.895,2.896,7.591,0,10.486L329.464,221.394z"></path> <polygon style="fill:#5C6670;" points="199.509,340.862 209.345,296.205 244.167,331.024 "></polygon> <rect x="347.427" y="155.548" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 516.1105 550.4132)" style="fill:#5C6670;" width="49.246" height="25.537"></rect> </g> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_genial`,
			title: 'Genially Embeder',
			icon: '<svg viewBox="0 0 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M0 1v14h17v-14h-17zM16 14h-15v-12h15v12zM4.646 10.354l-2.353-2.354 2.354-2.354 0.707 0.707-1.647 1.647 1.646 1.646-0.707 0.708zM11.646 9.646l1.647-1.646-1.646-1.646 0.707-0.707 2.353 2.353-2.354 2.354-0.707-0.708z" fill="#000000"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_sirv`,
			title: 'Sirv Embeder',
			icon: '<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M25.6 0H6.4C2.86538 0 0 2.86538 0 6.4V25.6C0 29.1346 2.86538 32 6.4 32H25.6C29.1346 32 32 29.1346 32 25.6V6.4C32 2.86538 29.1346 0 25.6 0Z" fill="url(#paint0_linear_103_1789)"></path> <path d="M5.9577 24.8845C5.42578 25.9483 6.19937 27.2 7.38878 27.2H18.2111C19.4005 27.2 20.1741 25.9483 19.6422 24.8845L14.231 14.0622C13.6414 12.8829 11.9585 12.8829 11.3688 14.0622L5.9577 24.8845Z" fill="white"></path> <path d="M15.5577 24.8845C15.0258 25.9483 15.7994 27.2 16.9888 27.2H24.6111C25.8005 27.2 26.5741 25.9483 26.0422 24.8845L22.231 17.2622C21.6414 16.0829 19.9585 16.0829 19.3688 17.2622L15.5577 24.8845Z" fill="white" fill-opacity="0.6"></path> <path d="M24.0002 11.2C25.7675 11.2 27.2002 9.76726 27.2002 7.99995C27.2002 6.23264 25.7675 4.79995 24.0002 4.79995C22.2329 4.79995 20.8002 6.23264 20.8002 7.99995C20.8002 9.76726 22.2329 11.2 24.0002 11.2Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_103_1789" x1="16" y1="0" x2="16" y2="32" gradientUnits="userSpaceOnUse"> <stop stop-color="#00E676"></stop> <stop offset="1" stop-color="#00C853"></stop> </linearGradient> </defs> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_mixcloud`,
			title: 'Mixcloud Embeder',
			icon: '<svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M29.265 25.416c-0.203 0-0.411-0.061-0.593-0.181-0.489-0.333-0.62-1-0.297-1.48 0.985-1.457 1.5-3.171 1.5-4.957 0-1.781-0.515-3.5-1.5-4.959-0.333-0.495-0.192-1.156 0.287-1.479 0.5-0.329 1.161-0.193 1.479 0.285 1.22 1.824 1.86 3.959 1.86 6.161 0 2.199-0.64 4.339-1.86 6.157-0.181 0.323-0.52 0.479-0.859 0.479zM26.213 23.693c-0.203 0-0.411-0.063-0.593-0.188-0.489-0.317-0.615-0.979-0.287-1.459 0.651-0.964 0.995-2.063 0.995-3.24 0-1.14-0.344-2.26-0.995-3.239-0.328-0.485-0.203-1.141 0.287-1.464 0.495-0.317 1.14-0.197 1.473 0.303 0.891 1.317 1.365 2.859 1.365 4.416 0 1.604-0.475 3.12-1.365 4.423-0.192 0.317-0.541 0.479-0.88 0.479zM21.24 14.151c-0.417-4.26-4.021-7.599-8.401-7.599-3.625 0-6.839 2.333-7.989 5.713-2.729 0.401-4.849 2.761-4.849 5.599 0 3.125 2.547 5.672 5.683 5.672h14.541c2.62 0 4.755-2.124 4.755-4.739 0-2.276-1.599-4.172-3.739-4.641zM20.224 21.416h-14.541c-1.953 0-3.557-1.588-3.557-3.547 0-1.952 1.588-3.541 3.557-3.541 0.948 0 1.844 0.38 2.515 1.041 0.401 0.417 1.084 0.417 1.5 0 0.401-0.4 0.401-1.083 0-1.5-0.739-0.724-1.64-1.244-2.619-1.484 1-2.219 3.239-3.697 5.739-3.697 3.48 0 6.323 2.839 6.323 6.317 0 0.683-0.104 1.344-0.323 1.979-0.177 0.563 0.12 1.161 0.683 1.365 0.099 0.036 0.219 0.057 0.317 0.057 0.443 0 0.86-0.281 1-0.719 0.141-0.423 0.24-0.839 0.303-1.281 0.979 0.38 1.677 1.339 1.677 2.443 0 1.457-1.177 2.635-2.62 2.635z"></path> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_kuula`,
			title: 'Kuula Embeder',
			icon: '<svg viewBox="0 0 128 128" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#1CA2BB;} .st1{fill:#EAC100;} </style> <g id="_x31_2_3D_Printing"></g> <g id="_x31_1_VR_Gear"></g> <g id="_x31_0_Virtual_reality"> <g> <path class="st1" d="M116,88c0,11-23.3,20-52,20s-52-9-52-20V48c0-11,23.3-20,52-20s52,9,52,20V88z"></path> <path class="st1" d="M32,63.8v40c-12.2-3.7-20-9.4-20-15.8V48C12,54.4,19.8,60.1,32,63.8z"></path> <path class="st1" d="M96,63.8v40c12.2-3.7,20-9.4,20-15.8V48C116,54.4,108.2,60.1,96,63.8z"></path> <circle class="st0" cx="64" cy="64" r="12"></circle> <path class="st0" d="M44,96c0-11,9-20,20-20c11,0,20,9,20,20"></path> <g> <circle cx="44" cy="48" r="4"></circle> <path d="M64,24C36.9,24,8,32.4,8,48v40c0,15.6,28.9,24,56,24s56-8.4,56-24V48C120,32.4,91.1,24,64,24z M64,32 c29.7,0,48,9.3,48,16c0,4.1-6.7,8.8-17.2,11.9L92,60.8V67c-3.7-0.9-7.7-1.6-12-2.1c0-0.3,0-0.6,0-0.9c0-8.8-7.2-16-16-16 s-16,7.2-16,16c0,0.3,0,0.6,0,0.9c-4.3,0.5-8.3,1.2-12,2.1v-6.2l-2.8-0.9C22.7,56.8,16,52.1,16,48C16,41.3,34.3,32,64,32z M112,60.8v14.3c-3.2-2.3-7.2-4.2-12-5.9v-2.6C104.8,65,108.9,63.1,112,60.8z M56,64c0-4.4,3.6-8,8-8s8,3.6,8,8s-3.6,8-8,8 S56,68.4,56,64z M28,69.3c-4.8,1.6-8.8,3.6-12,5.9V60.8c3.1,2.2,7.2,4.2,12,5.8V69.3z M16,88c0-3.3,4.3-7.1,12-10.1v20.3 C20.3,95.1,16,91.2,16,88z M36,100.8V75.3c4.3-1.1,9.2-2,14.6-2.6c0.5,0.8,1.1,1.6,1.8,2.3C45,79.1,40,87,40,96h8 c0-8.8,7.2-16,16-16s16,7.2,16,16h8c0-9-5-16.9-12.4-21c0.7-0.7,1.3-1.5,1.8-2.3c5.4,0.6,10.3,1.5,14.6,2.6v25.5 c-7.5,2-17,3.2-28,3.2S43.5,102.7,36,100.8z M100,98.2V77.9c7.7,3.1,12,6.9,12,10.1C112,91.2,107.7,95.1,100,98.2z"></path> </g> </g> </g> <g id="_x39__Augmented_reality"></g> <g id="_x38__Teleport"></g> <g id="_x37__Glassess"></g> <g id="_x36__Folding_phone"></g> <g id="_x35__Drone"></g> <g id="_x34__Retina_scan"></g> <g id="_x33__Smartwatch"></g> <g id="_x32__Bionic_Arm"></g> <g id="_x31__Chip"></g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_facebook`,
			title: 'Facebook Embeder',
			icon: '<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z"></path><path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z"></path></g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_pinterest`,
			title: 'Pinterest Embeder',
			icon: '<svg viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Pinterest-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-300.000000, -260.000000)" fill="#CC2127"> <path d="M324.001411,260 C310.747575,260 300,270.744752 300,284.001411 C300,293.826072 305.910037,302.270594 314.368672,305.982007 C314.300935,304.308344 314.357382,302.293173 314.78356,300.469924 C315.246428,298.522491 317.871229,287.393897 317.871229,287.393897 C317.871229,287.393897 317.106368,285.861351 317.106368,283.59499 C317.106368,280.038808 319.169518,277.38296 321.73505,277.38296 C323.91674,277.38296 324.972306,279.022755 324.972306,280.987123 C324.972306,283.180102 323.572411,286.462515 322.852708,289.502205 C322.251543,292.050803 324.128418,294.125243 326.640325,294.125243 C331.187158,294.125243 334.249427,288.285765 334.249427,281.36532 C334.249427,276.10725 330.707356,272.170048 324.263891,272.170048 C316.985006,272.170048 312.449462,277.59746 312.449462,283.659905 C312.449462,285.754101 313.064738,287.227377 314.029988,288.367613 C314.475922,288.895396 314.535191,289.104251 314.374316,289.708238 C314.261422,290.145705 313.996119,291.21256 313.886047,291.633092 C313.725172,292.239901 313.23408,292.460046 312.686541,292.234256 C309.330746,290.865408 307.769977,287.193509 307.769977,283.064385 C307.769977,276.248368 313.519139,268.069148 324.921503,268.069148 C334.085729,268.069148 340.117128,274.704533 340.117128,281.819721 C340.117128,291.235138 334.884459,298.268478 327.165285,298.268478 C324.577174,298.268478 322.138649,296.868584 321.303228,295.279591 C321.303228,295.279591 319.908979,300.808608 319.615452,301.875463 C319.107426,303.724114 318.111131,305.575587 317.199506,307.014994 C319.358617,307.652849 321.63909,308 324.001411,308 C337.255248,308 348,297.255248 348,284.001411 C348,270.744752 337.255248,260 324.001411,260" id="Pinterest"> </path> </g> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_linkedin`,
			title: 'Linkedin Embeder',
			icon: '<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#0A66C2" d="M12.225 12.225h-1.778V9.44c0-.664-.012-1.519-.925-1.519-.926 0-1.068.724-1.068 1.47v2.834H6.676V6.498h1.707v.783h.024c.348-.594.996-.95 1.684-.925 1.802 0 2.135 1.185 2.135 2.728l-.001 3.14zM4.67 5.715a1.037 1.037 0 01-1.032-1.031c0-.566.466-1.032 1.032-1.032.566 0 1.031.466 1.032 1.032 0 .566-.466 1.032-1.032 1.032zm.889 6.51h-1.78V6.498h1.78v5.727zM13.11 2H2.885A.88.88 0 002 2.866v10.268a.88.88 0 00.885.866h10.226a.882.882 0 00.889-.866V2.865a.88.88 0 00-.889-.864z"></path></g></svg>',
			demo: ``,
			docs: ``,
		},
		{
			name: `bae_reddit`,
			title: 'Reddit Embeder',
			icon: '<svg xmlns="http://www.w3.org/2000/svg" aria-label="Reddit" role="img" viewBox="0 0 512 512" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="512" height="512" rx="15%" fill="#f40"></rect> <g fill="#ffffff"> <ellipse cx="256" cy="307" rx="166" ry="117"></ellipse> <circle cx="106" cy="256" r="42"></circle> <circle cx="407" cy="256" r="42"></circle> <circle cx="375" cy="114" r="32"></circle> </g> <g stroke-linecap="round" stroke-linejoin="round" fill="none"> <path d="m256 196 23-101 73 15" stroke="#ffffff" stroke-width="16"></path> <path d="m191 359c33 25 97 26 130 0" stroke="#f40" stroke-width="13"></path> </g> <g fill="#f40"> <circle cx="191" cy="287" r="31"></circle> <circle cx="321" cy="287" r="31"></circle> </g> </g></svg>',
			demo: ``,
			docs: ``,
		},
	]
}