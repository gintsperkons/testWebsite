class ProductDetails extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            product: null,
            error: null
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
                        type={attribute.type} />
                    ))}
                    <h2 className={"attributeTitle"}>Price:</h2>
                    <p className={"detailsPrice"}>{product.prices[0].currency.symbol}{product.prices[0].amount}</p>
                    <button className = {"cartButton"}>Add to cart</button>
                    <div className={"productDescription"} dangerouslySetInnerHTML={{ __html: product.description }} />
                </div>
            </div>
        )
    }


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