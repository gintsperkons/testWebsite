

class Main extends React.Component {
    constructor(props) {
        super(props);
        // Initialize state
        this.state = {
            products: [],  // Store fetched products
            loading: true, // Loading state
            error: null    // Error state
        };
    }

    componentDidMount() {
        console.log('Main has been mounted!');
        this.fetchProducts(); // Fetch products when component mounts
    }

    // Function to fetch products from the GraphQL API
    fetchProducts = async () => {
        // Define your GraphQL query as a string
        const query = `
          query { products { id name inStock description category attributes { id name type items { id displayValue value } } prices { amount currency { label symbol } } brand gallery } }
        `;

        // Function to fetch data from a GraphQL API
        try {
            const response = await fetch('http://172.26.111.129/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    query: query
                })
            });

            const result = await response.json(); // Parse the JSON from the response
            console.log('Data from GraphQL:', result.data.products);
            // Update state with the fetched products
            this.setState({
                products: result.data.products,
                loading: false
            });
        } catch (error) {
            console.error('Error fetching GraphQL data:', error);

            // Update state with the error
            this.setState({
                loading: false,
                error: error
            });
        }
    };

    render() {
        const { products, loading, error } = this.state;

        // Render loading message if data is still being fetched
        if (loading) {
            return React.createElement('div', null, 'Loading...');
        }

        // Render error message if there was an error fetching data
        if (error) {
            return React.createElement('div', null, `Error: ${error.message}`);
        }

        // Render products if data has been successfully fetched
        return (
            <div>
                <Header />
                <h1>Products</h1>
                <div>
                    {products.map((product) => (
                        <div key={product.id}>
                            <h2>{product.name}</h2>
                            <p>{product.description}</p>
                            <p>{product.category}</p>
                            <p>{product.prices[0].amount} {product.prices[0].currency.symbol}</p>
                            <img src={product.gallery[0]} alt={product.name} />
                        </div>
                    ))}
                </div>
            </div>
        )
        
        
        
    }
}

// Get the root element from the DOM
const root = ReactDOM.createRoot(document.getElementById('root'));

// Render the React component into the root element
root.render(
    React.createElement(Main)
);
