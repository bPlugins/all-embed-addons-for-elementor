import { HashRouter as Router, Routes, Route, Navigate } from 'react-router-dom';

import Blocks from '../../../../bpl-tools/Admin/Blocks';
import Demos from '../../../../bpl-tools/Admin/Demos';
import Pricing from '../../../../bpl-tools/Admin/Pricing';
import FeatureCompare from '../../../../bpl-tools/Admin/FeatureCompare';
import Activation from '../../../../bpl-tools/Admin/Activation';
import OurPlugins from '../../../../bpl-tools/Admin/OurPlugins';

import Layout from './Layout';
import Welcome from './Welcome';
import blocks from '../utils/blocks';
import { demoInfo, pricingInfo } from '../utils/data';
import useWPAjax from '../../../../bpl-tools/hooks/useWPAjax';
import { useEffect, useState } from 'react';

const App = (props) => {
	const { isPremium, hasPro, action, nonce, status: externalStatus } = props;

	const [internalStatus, setInternalStatus] = useState(null);

	const { data = [], saveData, refetch, isLoading, error } = useWPAjax(
		action,
		{ _wpnonce: nonce },
		true
	);

	useEffect(() => {
		if (nonce && action) {
			refetch();
		}
	}, [nonce, action]);

	useEffect(() => {
		if (!isLoading && data) {
			setInternalStatus('success');
		}
	}, [data, isLoading]);
	

	const saveToBackend = (updatedBlocksName) => {
		setInternalStatus('loading');

		saveData({
			_wpnonce: nonce,
			data: JSON.stringify(updatedBlocksName)
		})
			.then(() => {
				setInternalStatus('success');
			})
			.catch(() => {
				setInternalStatus('error');
			});
	};

	return <Router>
		<Routes>
			<Route path='/' element={<Layout {...props} />}>
				<Route index element={<Welcome {...props} disabledBlocks={data} status={internalStatus} onChange={saveToBackend} />} />

				<Route path='welcome' element={<Welcome {...props} disabledBlocks={data} status={internalStatus} onChange={saveToBackend} />} />

				<Route path='widgets' element={<Blocks {...props} pageTitle = 'All Widgets' allBlocks={blocks} disabledBlocks={data} status={internalStatus} onChange={saveToBackend} />} />

				<Route path='demos' element={<Demos demoInfo={demoInfo} {...props} />} />

				{/* {!isPremium && <Route path='pricing' element={<Pricing pricingInfo={pricingInfo} options={{}} {...props} />} />} */}

				{/* {!isPremium && <Route path='feature-comparison' element={<FeatureCompare plans={['free', 'pro']} {...props} />} />} */}

				{hasPro && <Route path='activation' element={<Activation {...props} />} />}

				<Route path='our-plugins' element={<OurPlugins {...props} slugs={['3d-viewer', 'html5-video-player', 'document-embedder-addons-for-elementor', 'html5-audio-player', 'media-player-addons-for-elementor', 'pdf-poster', 'document-emberdder', 'advanced-post-block', 'b-carousel-block', 'b-blocks', 'html5-video-player']} />} />

				<Route path='*' element={<Navigate to='/welcome' replace />} />
			</Route>
		</Routes>
	</Router>
}
export default App;