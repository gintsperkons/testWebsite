class ProductDetails extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            product: null,
            error: null,
            selectedAttributes: []
        };
    }

    componentDidMount() {
        this.fetchProductById(this.props.productId)
            .then(product => {
                this.setState({
                    product: product
                });
            });
    }

    handleSelect = (attributeId, valueId) => {
        this.setState({ selectedAttributes: [...this.state.selectedAttributes, { attributeId, valueId }] });
    }


    render() {
        const { product, error } = this.state;

        if (error) {
            return (
                <p>Error: {error.message}</p>
            )
        }
        if (!product) {
            return (
                <p>Loading...</p>
            )
        }

        return (
            <div className="productDetails">
                <div className="productDetailsImage">
                    <ImageGallary images={product.gallery} />
                </div>
                <div className="productDetailsInfo">
                    <h1>{product.name}</h1>
                    {this.state.product.attributes.map((attribute) => (
                        <Attributes
                            key={attribute.id}
                            title={attribute.name}
                            attributes={attribute.items}
                            type={attribute.type}
                            id={attribute.id}
                            onSelect={this.handleSelect}
                        />
                    ))}
                    <h2 className={"attributeTitle"}>Price:</h2>
                    <p className={"detailsPrice"}>{product.prices[0].currency.symbol}{product.prices[0].amount}</p>
                    <button
                        data-testid='add-to-cart'
                        disabled={this.state.selectedAttributes.length < this.state.product.attributes.length}
                        onClick={() => {
                            this.props.addToCart(this.state.product, this.state.selectedAttributes);
                            this.props.toggleCart();
                        }}
                        className={`cartButton ${this.state.selectedAttributes.length < this.state.product.attributes.length? "disabled": ""}`}>
                        Add to cart
                    </button>
                    <div className={"productDescription"} data-testid='product-description' >{this.renderHTML(product.description)}</div>
                </div>
            </div>
        )
    }


    renderHTML = (description) => {
        const parser = new DOMParser();
        const parsedHtml = parser.parseFromString(description, 'text/html');
        const childNodes = parsedHtml.body.childNodes;

        const renderNode = (node) => {
            switch (node.nodeName) {
                case 'P':
                    return <p>{node.textContent}</p>;
                case 'B':
                    return <b>{node.textContent}</b>;
                case 'I':
                    return <i>{node.textContent}</i>;
                case 'BR':
                    return <br />;
                default:
                    return node.textContent; // For text and unsupported tags
            }
        };

        return Array.from(childNodes).map((node, index) => <React.Fragment key={index}>{renderNode(node)}</React.Fragment>);
    };
    fetchProductById = async (id) => {
        const query = `
          query { product(id: "${id}") { id name inStock description category attributes { id name type items { id displayValue value } } prices { amount currency { label symbol } } brand gallery } }
        `;

        try {
            const response = await fetch('/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    query: query
                })
            });

            const result = await response.json();
            console.log('Data from GraphQL:', result.data.product);

            return result.data.product;
        } catch (error) {
            console.error('Error fetching GraphQL data:', error);

            this.setState({
                error: error
            });
        }
    }



}

window.ProductDetails = ProductDetails;