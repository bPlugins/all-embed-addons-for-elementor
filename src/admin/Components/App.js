import { HashRouter as Router, Routes, Route, Navigate } from 'react-router-dom';

import ListDemos from '../../../../bpl-tools/Admin/Demos/ListDemos';
import FSCheckoutButton from '../../../..//bpl-tools/Admin/FSCheckoutButton/FSCheckoutButton';
// import FilterDemos from '../../../..//bpl-tools/Admin/Demos/FilterDemos';
// import Pricing from '../../../..//bpl-tools/Admin/Pricing/Pricing';
import Blocks from '../../../..//bpl-tools/Admin/Blocks/Blocks';
// import FeatureCompare from '../../../../bpl-tools/Admin/FeatureCompare/FeatureCompare';

import Layout from './Layout';
import { demoInfo, pricingInfo, filterDemoInfo, blocksInfo } from '../utils/data'; //akne hobe featureCompareInfo jodi lage
import Welcome from './Welcome';

const App = (props) => {
	const { name, isPremium, freemius, nonce } = props;

	return <Router>
		<Routes>
			<Route path='/' element={<Layout {...props} />}>
				<Route index element={<Welcome {...props} />} />

				<Route path='welcome' element={<Welcome {...props} />} />

				<Route path='demos' element={<ListDemos demoInfo={demoInfo} {...props}>
					{/* {!isPremium && <FSCheckoutButton {...{
						link :"/wp-admin/admin.php?page=all-embed-addons-for-elementor#/pricing",
						freemius,
						options: { title: name }
					}}>Buy Now</FSCheckoutButton>} */}
				</ListDemos>} />

				{/* <Route path='demos' element={<FilterDemos demoInfo={filterDemoInfo}{...props}>
					{!isPremium && <FSCheckoutButton {...{
						link :"/wp-admin/admin.php?page=all-embed-addons-for-elementor#/pricing",
						freemius,
						options: { title: name }
					}}>
						<svg fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink" viewBox="0 0 370 370" xmlSpace="preserve"><g id="SVGRepo_bgCarrier" strokeWidth="0"></g><g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M366.85,71.242c-2.842-3.661-7.217-5.802-11.85-5.802H97.836L87.698,37.929c-2.173-5.896-7.791-9.813-14.075-9.813H15 c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15h48.165l85.384,231.704c2.173,5.897,7.791,9.814,14.075,9.814h147.823 c8.283,0,15-6.716,15-15c0-8.284-6.717-15-15-15H173.082l-13.572-36.829h160.319c6.852,0,12.832-4.642,14.531-11.279L369.531,84.16 C370.681,79.671,369.69,74.902,366.85,71.242z M189.627,123.068l25.795-25.795c2.834-2.833,6.6-4.393,10.607-4.393 s7.773,1.561,10.607,4.394l25.791,25.793c2.834,2.834,4.395,6.6,4.395,10.606c0,4.007-1.561,7.773-4.395,10.607 c-2.834,2.833-6.602,4.393-10.607,4.393c-4.006,0-7.773-1.56-10.605-4.394l-0.188-0.186v24.236c0,8.271-6.729,15-15,15 c-8.271,0-15-6.729-15-15v-24.234l-0.188,0.187c-2.834,2.833-6.6,4.393-10.605,4.393c-4.006,0-7.773-1.56-10.607-4.393 C183.779,138.433,183.779,128.917,189.627,123.068z"></path> <path d="M181.482,303.196c-10.687,0-19.347,8.658-19.347,19.344c0,10.686,8.66,19.344,19.347,19.344 c10.686,0,19.347-8.659,19.347-19.344C200.829,311.854,192.169,303.196,181.482,303.196z"></path> <path d="M282.311,303.196c-10.686,0-19.347,8.658-19.347,19.344c0,10.686,8.66,19.344,19.347,19.344s19.342-8.659,19.342-19.344 C301.653,311.854,292.998,303.196,282.311,303.196z"></path> </g> </g></svg>
						Buy Now
					</FSCheckoutButton>}
				</FilterDemos>} /> */}

				{/* {!isPremium && <Route path='pricing' element={<>
					<Pricing pricingInfo={pricingInfo} options={{}} {...props}>
						<h2 style={{ textAlign: 'center', fontSize: '30px', fontWeight: "bold", marginBottom: '25px' }}>One-time payment, lifetime access</h2>
					</Pricing>
				</>} />} */}


				{/* {!isPremium && <Route path='feature-comparison' element={<FeatureCompare featureCompareInfo={featureCompareInfo} {...props} />} />} */}


				<Route path='/widgets' element={<Blocks info={blocksInfo} nonce={nonce} />} />
				<Route path='*' element={<Navigate to='/welcome' replace />} />
			</Route>
		</Routes>
	</Router>
}
export default App;