


class App extends React.Component {
    constructor(props) {
        super(props);
        this.products = {};
        this.state = {
            cart: [],
            categories: [{ "name": "all" }],
            products: [],
            error: null,
            selectedCategory: null,
            view: 'catalog',
            id: null,
            isCartOpen: false
        };
    };

    componentDidMount() {
        window.addEventListener('popstate', this.handlePopState);
        this.handleNavigation();
        var category = localStorage.getItem('selectedCategory');
        

        var cart = localStorage.getItem('cart');
        if (cart) {
            this.setState({ cart: JSON.parse(cart) });
        }
        if (category) {
            this.setState({ selectedCategory: localStorage.getItem('selectedCategory') });
            this.fetchCategories();
            this.fetchProductsByCategory(localStorage.getItem('selectedCategory'));
        } else {
            this.fetchCategories();
            this.fetchProductsByCategory('all');
        }
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
                        isCartOpen={this.state.isCartOpen}
                        onCategoryClick={this.handleCategoryClick}
                        cart={this.state.cart}
                        clearCart={this.clearCart}
                        addToCart={this.addToCart} removeFromCart={this.removeFromCart}
                        toggleCart={this.toggleCart}
                    />
                    <div className={"body"}>
                        <ProductDetails productId={this.state.id} addToCart={this.addToCart}  
                        toggleCart={this.toggleCart}/>
                    </div>
                </div>

            );

        }
        if (view === 'catalog') {
            return (
                <div>
                    <Header
                        categories={categories}
                        selectedCategory={selectedCategory}
                        isCartOpen={this.state.isCartOpen}
                        onCategoryClick={this.handleCategoryClick}
                        cart={this.state.cart}
                        clearCart={this.clearCart}
                        addToCart={this.addToCart} removeFromCart={this.removeFromCart}
                        toggleCart={this.toggleCart}
                    />
                    <div className={"body"}>
                        <Catalog products={products} catalogTitle={selectedCategory} productClicked={this.handleProductClick} addToCart={this.addToCart} removeFromCart={this.removeFromCart} />
                    </div>
                </div>
            );
        }





    }

    removeFromCart = (product) => {
        for (let i = 0; i < this.state.cart.length; i++) {
            if (this.state.cart[i].product.id === product.id) {
                if (this.state.cart[i].quantity > 1) {
                    this.state.cart[i].quantity--;
                } else {
                    this.state.cart.splice(i, 1);
                }
                this.setState({ cart: this.state.cart });
                return;
            }
        }
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    addToCart = (product, selectedAttributes) => {
        if (!selectedAttributes) {
            selectedAttributes = [];
        }
        
        console.log('Adding to cart:', product, selectedAttributes);
    
        // Check if the product already exists in the cart
        const cart = this.state.cart.slice();
        let productExistsInCart = false;
    
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].product.id === product.id) {
                // Product exists in the cart, update quantity and selectedAttributes
                cart[i].quantity++;
                cart[i].selectedAttributes = selectedAttributes;
                productExistsInCart = true;
                break; // Exit the loop as we found the product
            }
        }
    
        // If the product is not found in the cart, add it as a new entry
        if (!productExistsInCart) {
            // Fill missing attributes
            const tempAttributes = [];
            for (let i = 0; i < product.attributes.length; i++) {
                let attributeFound = false;
                for (let j = 0; j < selectedAttributes.length; j++) {
                    if (selectedAttributes[j].attributeId === product.attributes[i].id) {
                        attributeFound = true;
                        break;
                    }
                }
                // If the attribute is not found in selectedAttributes, add default one
                if (!attributeFound) {
                    tempAttributes.push({ 
                        attributeId: product.attributes[i].id, 
                        valueId: product.attributes[i].items[0].id 
                    });
                }
            }
    
            selectedAttributes = [...selectedAttributes, ...tempAttributes];
    
            cart.push({ product: product, quantity: 1, selectedAttributes: selectedAttributes });
        }
    
        this.setState({ cart: cart });
        localStorage.setItem('cart', JSON.stringify(cart));
    }


    clearCart = () => {
        this.setState({ cart: [] });
    }

    //Handles
    handlePopState = (event) => {
        if (event.state) {
            const { view, id, category } = event.state;
            this.setState({ view, id }, () => {
                this.navigate(view, id, category);
            });
        }
    };

    navigate = (view, id, category) => {
        console.log('Navigating to:', view, id);
        if (view === 'catalog' && id) {
            localStorage.setItem('selectedCategory', category);
            this.setState({ selectedCategory: category });
            if (this.products[id]) {
                this.setState({ products: this.products[id] });
            } else {
                this.fetchProductsByCategory(category);
            }
        }
    }

    handleNavigation = (view = null, id = null) => {
        const url = new URL(window.location.href);
        var category = url.pathname.slice(1);
        if (category === 'tech' || category === 'clothes' || category === 'all') {
            this.setState({ selectedCategory: url.pathname.slice(1) });
            localStorage.setItem('selectedCategory', category);
            category = url.pathname.slice(1);
        } else { 
            category === 'all'; 
            localStorage.setItem('selectedCategory', category);
            this.setState({ selectedCategory: 'all' });
        }

        

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

        // Navigate and update the browser history
        console.log('Navigating to:', view, id);
        this.navigate(view, id, category);
        window.history.pushState({ view, id, category }, '', url.toString());
        this.setState({ view, id });
    };



    handleProductClick = (product) => {
        console.log('Product clicked:', product);
        this.handleNavigation('details', product.id);
    }

    handleCategoryClick = (category) => {
        localStorage.setItem('selectedCategory', category);
        this.handleNavigation('catalog', category);
    }

    toggleCart = () => {
        console.log('Toggling cart');
        this.setState({ isCartOpen: !this.state.isCartOpen });
        if (this.state.isCartOpen) {
            document.getElementsByClassName("body")[0].classList.remove("cartOpen");
        } else {
            document.getElementsByClassName("body")[0].classList.add("cartOpen");
        }
    };



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
                categories: [{ "name": "all" }, ...result.data.categories],
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
          query { products(category: "${category}") { id name inStock description category attributes { id name type items { id displayValue value } } prices { amount currency { label symbol } } brand gallery } }
        
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
