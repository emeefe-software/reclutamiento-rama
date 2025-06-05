import { storiesOf } from '@storybook/vue';
import '../sass/dashboard/style.scss'

storiesOf('b-button', module).add('Default', () => ({
    template: '<b-button>Button</b-button>'
}));