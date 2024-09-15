
class Header extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            categories: props.categories,
            selectedCategory: props.selectedCategory
        };
    }



    componentDidUpdate(prevProps) {
        if (prevProps.categories !== this.props.categories) {
            this.setState({
                categories: this.props.categories
            });
        }
        if (prevProps.selectedCategory !== this.props.selectedCategory) {
            this.setState({
                selectedCategory: this.props.selectedCategory
            });
        }
    }

    render() {
        return (
            <header id="header">
                <nav className="navigation">
                    {this.state.categories.map((category, index) => (
                        <NavigationItem
                            key={index}
                            itemName={category.name}
                            selected = {category.name === this.state.selectedCategory}
                            onClick={() => this.props.onCategoryClick(category.name)}
                        />
                    ))}

                </nav>
                <img className={"storeIcon"} src="https://cdn-images-1.medium.com/v2/resize:fit:184/1*Y_sgnCWYyqFHYExu4J7i7w@2x.png" alt="logo" />
                <Cart 
                        isCartOpen={this.props.isCartOpen}
                        toggleCart={this.props.toggleCart}  clearCart = {this.props.clearCart} cart = {this.props.cart} addToCart={this.props.addToCart} removeFromCart={this.props.removeFromCart} />
            </header>
        )
    }
}






window.Header = Header;