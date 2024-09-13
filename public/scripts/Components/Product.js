class Product extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            key: props.key,
            product: props.product
        };
    }

    componentDidUpdate(prevProps) {
        if (prevProps.product !== this.props.product) {
            this.setState({
                product: this.props.product
            });
        }
    }


    render() {
        return (
            <div className={`product ${!this.state.product.inStock ? 'outOfStock' : ''}`} onClick = {() => this.props.productClicked(this.state.product)}>
                <div className="productImageWrapper">
                    <img
                        className={`productImage ${!this.state.product.inStock ? 'outOfStock' : ''}`}
                        src={this.state.product.gallery[0]}
                        alt={this.state.product.name}
                    />
                    {!this.state.product.inStock && (
                        <div className="productOutOfStock">Out of stock</div>
                    )}
                </div>
                <p className="productTitle">{this.state.product.name}</p>
                <p className="productPrice">
                    {this.state.product.prices[0].currency.symbol}
                    {this.state.product.prices[0].amount}
                </p>
                <div className="productCartImageWrapper">
                    <img className={"productCartImage"} src="/images/shopping-cart-svgrepo-com.svg" alt="cart" />
                </div>
            </div>

        );
    }
}

window.Product = Product;