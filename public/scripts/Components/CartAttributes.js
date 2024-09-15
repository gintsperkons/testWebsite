class CartAttributes extends React.Component {
    constructor(props) {
      super(props);
      this.state = {
        attributes: props.attributes,
        title: props.title,
        type: props.type,
        id: props.id,
        productId: props.productId,
        selected: this.props.selected,
      };
    }
  
  
    render() {
      return (
        <div className="cartAttributes">
          <h2 className={"cartAttributeTitle"}>{this.props.title}:</h2>
          <div className="cartAttributesContainer" data-testid={`cart-item-attribute-${this.props.title.replace(/\s+/g, '-').toLowerCase()}`} >
            {this.props.attributes.map((attribute, index) => {
              const isSelected = this.state.selected === index || this.props.selected === index;
              const className = this.state.type;
              const style = this.state.type === "swatch" ? { backgroundColor: attribute.value } : {};
  
              return (
                <div data-testid={`cart-item-attribute-${this.props.title.replace(/\s+/g, '-').toLowerCase()}-${attribute.value.replace(/\s+/g, '-').toLowerCase()}${isSelected ? '-selected' : ''}`}                 
                    key={index}
                  className={`${className} ${isSelected ? 'selected' : ''}`}
                  style={style}
                >
                  {this.state.type === "text" ? attribute.value : null}
                </div>
              );
            })}
          </div>
        </div>
      );
    }
  


    handleSelect = (attribute,index) => {
        console.log("attribute",attribute);
        console.log("index",this.props.selected);
        this.setState({ selected: index }, () => {
            if (this.props.onSelect) {
                this.props.onSelect(this.state.id,attribute,this.state.productId);
            }
        });
    };


  
  }
  
  window.CartAttributes = CartAttributes;
  