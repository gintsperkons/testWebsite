


class App extends React.Component {
    constructor(props) {
        super(props);
        this.products = {};
        this.state = {
            categories: [],
            products: [],
            error: null,
            selectedCategory: null,
            view: 'catalog',
            id: null
        };
    };

    componentDidMount() {
        window.addEventListener('popstate', this.handlePopState);
        this.handleNavigation();
        this.setState({ selectedCategory: localStorage.getItem('selectedCategory') });
        this.fetchCategories();
        this.fetchProductsByCategory(localStorage.getItem('selectedCategory'));
    }

    componentWillUnmount() {
        window.removeEventListener('popstate', this.handlePopState);
    }

    render() {
        const { error, view, categories, products, selectedCategory } = this.state;

        if (error) {
            return (
                <p>Error: {error.message}</p>
            )
        }



        if (view === 'details') {
            return (
                <div>
                    <Header
                        categories={categories}
                        selectedCategory={selectedCategory}
                        onCategoryClick={this.handleCategoryClick}
                    />
                    <ProductDetails productId = {this.state.id} />
                </div>

            );

        }
        if (view === 'catalog') {
            return (
                <div>
                    <Header
                        categories={categories}
                        selectedCategory={selectedCategory}
                        onCategoryClick={this.handleCategoryClick}
                    />
                    <Catalog products={products} catalogTitle={selectedCategory} productClicked={this.handleProductClick} />
                </div>
            );
        }





    }


    //Handles
    handlePopState = (event) => {
        if (event.state) {
            const { view, id } = event.state;
            this.setState({ view, id }, () => {
                this.navigate(view, id);
            });
        }
    };

    navigate = (view, id) => {
        if (view === 'catalog') {
            localStorage.setItem('selectedCategory', id);
            this.setState({ selectedCategory: id });
            if (this.products[id]) {
                this.setState({ products: this.products[id] });
            } else {
                this.fetchProductsByCategory(id);
            }
        }
    }

    handleNavigation = (view = null, id = null) => {
        const url = new URL(window.location.href);

        if (!view) {
            view = url.searchParams.get('view') || 'catalog';
        }
        if (id === null) {
            id = url.searchParams.get('id');
        }

        url.searchParams.set('view', view);
        if (id) {
            url.searchParams.set('id', id);
        } else {
            url.searchParams.delete('id');
        }

        this.navigate(view, id);

        
        
        window.history.pushState({ view, id }, '', url.toString());

        this.setState({ view: view, id: id });
    };


    handleProductClick = (product) => {
        console.log('Product clicked:', product);
        this.handleNavigation('details', product.id);
    }

    handleCategoryClick = (category) => {
        localStorage.setItem('selectedCategory', category);
        this.handleNavigation('catalog', category);
    }


    //Fetches

    fetchCategories = async () => {
        const query = `
          query { categories { name } }
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
            console.log('Data from GraphQL:', result.data.categories);

            this.setState({
                categories: result.data.categories,
                loading: false
            });
        } catch (error) {
            console.error('Error fetching GraphQL data:', error);

            this.setState({
                error: error
            });
        }
    };

    fetchProductsByCategory = async (category) => {
        const query = `
          query { products(category: "${category}") { id name inStock description category gallery prices { amount currency { symbol } } } }
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
            console.log('Data from GraphQL:', result.data.products);
            this.products[category] = result.data.products;
            this.setState({
                products: result.data.products,
                loading: false
            });
        } catch (error) {
            console.error('Error fetching GraphQL data:', error);

            this.setState({
                error: error
            });
        }
    }

    fetchProductById = async (id) => {
        const query = `
          query { product(id: "${id}") { id name inStock description category gallery prices { amount currency { symbol } } } }
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



const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    React.createElement(App)
)
