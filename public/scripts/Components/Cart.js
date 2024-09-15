class Cart extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: props.cart || [],
            isCartOpen: this.props.isCartOpen,
        };
    }

    componentDidUpdate(prevProps) {
        if (prevProps.cart !== this.props.cart) {
            this.setState({
                cart: this.props.cart || [],
            });
        }
        if (prevProps.isCartOpen !== this.props.isCartOpen) {
            this.setState({
                isCartOpen: this.props.isCartOpen,
            });
        }
    }


    calculateTotal = () => {
        return this.state.cart.reduce((total, item) => {
            return total + (item.product.prices[0].amount * item.quantity);
        }, 0);
    };

    handlePlaceOrder = () => {
        this.state.cart.forEach((item, index) => {
            console.log(`Item ${index + 1}`);
            console.log(item);
            console.log(`Product Name: ${item.product.name}`);
            console.log(`Quantity: ${item.quantity}`);
            this.placeOrder([
                {
                    productId: item.product.id,
                    quantity: item.quantity,
                    selectedAttributes: item.selectedAttributes
                }
            ]);
        });
        this.props.clearCart();
    };

    handleSelectAttribute = (setId, selectedAttribute, itemIndex) => {
        console.log(setId);
        console.log(selectedAttribute);
        console.log(itemIndex);
        const cart = this.state.cart;
        console.log(cart);
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].product.id === itemIndex) {
                for (let j = 0; j < cart[i].selectedAttributes.length; j++) {
                    console.log(cart[i].selectedAttributes[j]);
                    console.log(selectedAttribute);
                    if (cart[i].selectedAttributes[j].attributeId === setId) {
                        cart[i].selectedAttributes[j].valueId = selectedAttribute.id;
                        this.setState({ cart: cart });
                        return;
                    }
                }
                cart[i].selectedAttributes.push({ attributeId: setId, valueId: selectedAttribute.id });
                break;
            }
        }
        this.setState({ cart: cart });
    };

    calculateCount = () => {
        return this.state.cart.reduce((total, item) => {
            return total + item.quantity;
        }, 0);
    };

    selectedIndex = (setId, listOfPosibilities, productId) => {
        const cart = this.state.cart;
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].product.id === productId) {
                for (let j = 0; j < cart[i].selectedAttributes.length; j++) {
                    if (cart[i].selectedAttributes[j].attributeId === setId) {
                        for (let k = 0; k < listOfPosibilities.length; k++) {
                            if (listOfPosibilities[k].id === cart[i].selectedAttributes[j].valueId) {
                                return k;
                            }
                        }

                    }
                }
            }
        }
        return 0;
    }

    render() {
        const total = this.calculateTotal();
        const count = this.calculateCount();

        return (
            <div>
                <div className={"clickableCartIcon"}  data-testid='cart-btn' >
                    <img
                        className={"cartIcon"}
                        src="/images/shopping-cart-svgrepo-com.svg"
                        alt="Cart"
                        onClick={this.props.toggleCart}
                    />
                    {this.state.cart.length > 0 &&
                        <div className="cartCountBubble">
                            {count}
                        </div>
                    }
                </div>
                <div data-testid="cart-overlay" className={`cartPopup ${this.state.isCartOpen ? "open" : ""}`}>
                    <p><b>My Bag,</b> {this.state.cart.length} {count === 1 ? "item" : "items"}</p>

                    <div className={"cartItems"}>
                        {this.state.cart.map((item, index) => (
                            <div key={index}>
                                <div className={"cartInfoTexts"} >
                                    <p className={"cartItemTitle"}>{item.product.name}</p>
                                    <p className={"cartItemPrice"}>{item.product.prices[0].currency.symbol}{item.product.prices[0].amount}</p>
                                    <div>
                                        {item.product.attributes.map((attribute) => (
                                            <div key={attribute.id}>
                                                <CartAttributes
                                                    key={attribute.id}
                                                    title={attribute.name}
                                                    attributes={attribute.items}
                                                    id={attribute.id}
                                                    type={attribute.type}
                                                    productId={item.product.id}
                                                    selected={
                                                        this.selectedIndex(attribute.id, attribute.items, item.product.id)
                                                    }

                                                    onSelect={(setId, selectedAttribute, itemIndex) => this.handleSelectAttribute(setId, selectedAttribute, itemIndex)}
                                                />
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                <div className={"quantityWrapper"}>
                                    <button data-testid='cart-item-amount-decrease' onClick={() => this.props.removeFromCart(item.product)}>-</button>
                                    <p data-testid='cart-item-amount'>Quantity: {item.quantity}</p>
                                    <button data-testid='cart-item-amount-increase' onClick={() => this.props.addToCart(item.product)}>+</button>
                                </div>
                                <div className={"cartItemImageCont"}>
                                    <img src={item.product.gallery[0]} />
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className={"orderButtonWrapper"}>
                        <p data-testid='cart-total'>Total: ${total.toFixed(2)}</p>
                        <button
                            className={`placeOrderButton ${count <= 0 ? "disabled" : ""}`}
                            disabled={count <= 0}
                            onClick={this.handlePlaceOrder}
                        >
                            PLACE ORDER
                        </button>
                    </div>
                </div>
            </div>
        );
    }

    placeOrder = async (orderInput) => {
        const mutation = `
          mutation PlaceOrder($input: [PlaceOrderInput!]!) {
            placeOrder(input: $input) 
          }
        `;

        const variables = {
            input: orderInput // Pass the array of products
        };

        try {
            const response = await fetch('/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    query: mutation,
                    variables: variables
                })
            });

            const result = await response.json();

            if (response.ok) {
                console.log('Mutation result:', result.data.placeOrder);
                return result.data.placeOrder;
            } else {
                console.error('GraphQL error:', result.errors);
                throw new Error(result.errors.map(e => e.message).join(', '));
            }
        } catch (error) {
            console.error('Error fetching GraphQL data:', error);
            throw error;
        }
    };



}

window.Cart = Cart;
