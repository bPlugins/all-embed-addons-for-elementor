import Overview from '../../../../bpl-tools/Admin/Overview/Overview';
import Changelog from '../../../../bpl-tools/Admin/Changelog/Changelog';
import FSCheckoutButton from '../../../../bpl-tools/Admin/FSCheckoutButton/FSCheckoutButton';

import { changelogs } from '../utils/data';
import SaveData from './SavaData';

const Custom = (props) => {
	const { name, isPremium, freemius } = props;

	return <>
    <div className='bPlDashboardBox bPlDashboardPricing'>
		<SaveData />
	</div>
    </>
}
export default Custom;
