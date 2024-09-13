class Catalog extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            products: props.products
        };
    }

    componentDidUpdate(prevProps) {
        if (prevProps.products !== this.props.products) {
            this.setState({
                products: this.props.products
            });
        }
    }

    render() {
        return (
            <div>
                <h1 className={"catalogTitle"}>{this.props.catalogTitle}</h1>
                <div className={"catalog"}>
                    {this.state.products.map((product, index) => (
                        <Product key={index} product={product}  productClicked = {this.props.productClicked}/>
                    ))}
                </div>
            </div>
        );
    }
}

window.Catalog = Catalog;