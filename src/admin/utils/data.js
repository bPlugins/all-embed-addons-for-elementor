import { VimeoIcon, youTubeIcon, soundCloudIcon, slideShareIcon, dartfishIcon, sirvIcon, redditIcon, geniallyIcon, linedInIcon, pinterestIcon, facebookIcon, bandcampIcon, mixcloudIcon, kuulaIcon, dailyMotionIcon, twitchIcon, twitframeIcon, codepenIcon, invisionIcon, jotFormIcon,appointlyIcon, imgurIcon, giphyIcon, spotifyIcon, googleMapIcon } from './blocksIcon';

const slug = 'all-embed-addons-for-elementor';

export const dashboardInfo = (info) => {
	const { version, isPremium, hasPro } = info;
	const adminUrl = info.adminUrl || window.ajaxurl?.split('admin-ajax.php')[0] || '';

	const proSuffix = isPremium ? ' ' : '';

	return {
		name: `All Embed Addons for Elementor ${proSuffix}`,
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
		adminUrl,
		action: 'bptbGetBlocks',
		displayOurPlugins: true,
		pages: {
			org: `https://wordpress.org/plugins/${slug}/`,
			landing: `https://bplugins.com/products/${slug}/`,
			docs: `https://bplugins.com/docs/${slug}/`,
			pricing: `https://bplugins.com/products/${slug}/pricing`,
		},
		freemius: {
			product_id: 21017,
			plan_id: 35063,
			public_key: 'pk_403fb9d96b1dd70da1ebcfb4851c2'
		},
		media: {
			logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`,
			banner: `https://ps.w.org/${slug}/assets/banner-772x250.png`,
			thumbnail: `https://bplugins.com/wp-content/uploads/2024/07/embed-docs-banner.png`,
			//proThumbnail: `https://bplugins.com/wp-content/themes/b-technologies/assets/images/products/${slug}-pro.png`,
			// video: 'https://www.youtube.com/watch?v=milYZrqLJsE',
			isYoutube: false
		},
		startButton: {
			label: 'Start Editing Now',
			url: `${adminUrl}post-new.php?post_type=page`
		}
	}
}

export const welcomeInfo = (adminUrl = '') => ({
	keywords: [
		'YouTube', 'Vimeo', 'SoundCloud', 'Spotify', 
		'Google Map', 'Twitch', 'Facebook', 'Pinterest', 
		'LinkedIn', 'Reddit', 'CodePen'
	],
	keywordsLabel: 'Supported Sources',
	gettingStarted: {
		tabs: [
			{
				key: 'elementor',
				label: 'Elementor',
				icon: <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>,
				steps: [
					{
						num: 1,
						title: 'Create or Edit a Page',
						body: 'Go to <strong>Pages › Add New</strong> and click <strong>Edit with Elementor</strong>.',
						link: {
							url: `${adminUrl}post-new.php?post_type=page`,
							label: 'Create New Page'
						}
					},
					{
						num: 2,
						title: 'Search for All Embed Widgets',
						body: 'In the Elementor panel, search for "YouTube Embeder", "Vimeo Embeder", "Spotify Embeder", etc.'
					},
					{
						num: 3,
						title: 'Drag and Drop',
						body: 'Drag the widget onto your section and enter the media URL in the content settings.'
					}
				]
			}
		]
	},
	changelogsLimit: 4,
	changelogsReadMoreLabel: 'View More Changelogs',
	proFeatures: [
		'Embed prototypes and visually rich layouts from InVision and Genially.',
		'Showcase high-resolution or zoomable media from Imgur, Sirv, and Kuula.',
		'Integrate custom contact and subscription forms using JotForm.',
		'Add professional video analysis and clips via Dartfish integration.',
		'Unlock additional styling, custom sizing, and alignment controls for all platforms.'
	],
	changelogs: [
		{
			version: '1.1.8 - 12 July 2026',
			type: 'update',
			list: [
				'<strong>Update</strong> Add New Admin Dashboard',
				'<strong>Update</strong> Update Freemius SDK to new version 2.13.4',
			]
		},
		{
			version: '1.1.7 - 05 July 2026',
			type: 'update',
			list: [
				'<strong>Update</strong> Update Freemius SDK to new version 2.13.2',
			]
		},
		{
			version: '1.1.6 - 25 Feb 2026',
			type: 'update',
			list: [
				'<strong>Update</strong> Update Admin Dashboard',
			]
		},
		{
			version: '1.1.5',
			type: 'update',
			list: [
				'<strong>Fixed</strong> Fix TwitFrame Embedder Error',
				'<strong>Fixed</strong> Fix Redit Embedder Error'
			]
		},
		{
			version: '1.1.4',
			type: 'fix',
			list: [
				'<strong>Fixed</strong> Fixed Cross Site Scripting (XSS)'
			]
		},
		{
			version: '1.1.2',
			type: 'fix',
			list: [
				'<strong>Fixed</strong> Fixed deprecated error'
			]
		},
		{
			version: '1.0.0',
			type: 'new',
			list: [
				'<strong>New</strong>Initial release'
			]
		}
	]
})


export const demoInfo = {
	title: 'Live Overview',
	description: 'Click on any style to view it live',
	allInOneLabel: 'See All Demo',
	allInOneLink: 'https://bplugins.com/products/all-embed-addons-for-elementor/#demos',
	demos: [
		{
			icon: linedInIcon,
			title: 'Linkedin Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/linkedin-embed/'
		},
		{
			icon: facebookIcon,
			title: 'Facebook Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/facebook-embed/'
		},
		{
			icon: pinterestIcon,
			title: 'Pinterest Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/pinterest-embed/'
		},
		{
			icon: kuulaIcon,
			title: 'Kuula Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/kuula-embed/'
		},
		{
			icon: sirvIcon,
			title: 'Sirv Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/sirv-embed/'
		},
		{
			icon: mixcloudIcon,
			title: 'Mixcloud Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/mixcloud-embed/'
		},
		{
			icon: dartfishIcon,
			title: 'Dartfish Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/dartfish-embed/'
		},
		{
			icon: dailyMotionIcon,
			title: 'Dailymotion Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/daily-motion-embed/'
		},
		{
			icon: bandcampIcon,
			title: 'Bandcamp Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/bandcamp-embed/'
		},
		{
			icon: codepenIcon,
			title: 'Codepen Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/codepen-embed/'
		},
		{
			icon: spotifyIcon,
			title: 'Spotify Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/spotify-embed/'
		},
		{
			icon: appointlyIcon,
			title: 'Appointly Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/appointly-embed/'
		},
		{
			icon: giphyIcon,
			title: 'Giphy Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/giphy-embed/'
		},
		{
			icon: youTubeIcon,
			title: 'YouTube Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/youtube-embed/'
		},
		{
			icon: VimeoIcon,
			title: 'Vimeo Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/vimeo-embed/'
		},
		{
			icon: soundCloudIcon,
			title: 'Soundcloud Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/soundcloud-embed/'
		},
		{
			icon: jotFormIcon,
			title: 'JotForm Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/jotform-embed/'
		},
		{
			icon: googleMapIcon,
			title: 'Google Map Embed',
			description: '',
			category: '',
			type: 'iframe',
			url: 'https://elementor.bplugins.com/demo/google-map-embed/'
		},
	]
}

export const pricingInfo = {
	logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`, // Optional
	pluginId: 21017,
	planId: 35063,
	licenses: [
		1,
		3,
		null
	],
	button: {
		label: 'Buy Now ➜'
	},
	featured: {
		selected: 3, // choose from licenses item
	},
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
}

