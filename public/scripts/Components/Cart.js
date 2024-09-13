class Cart extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <img className = {"cartIcon"} src= "/images/shopping-cart-svgrepo-com.svg" />
        );
    }
}

window.Cart = Cart;
