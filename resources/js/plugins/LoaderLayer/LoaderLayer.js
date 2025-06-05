import Loader from './Loader'
import './Loader.scss'

const LoaderLayer = {
    install(Vue, options) {
        Vue.Loader = new Loader();
    }
}

export default LoaderLayer;