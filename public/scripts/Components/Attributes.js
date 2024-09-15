class Attributes extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      attributes: props.attributes,
      title: props.title,
      type: props.type,
      id: props.id,
      selected: null, // Track the selected attribute
    };
  }


  render() {
    return (
      <div className="attributes">
        <h2 className={"attributeTitle"}>{this.props.title}:</h2>
        <div className="attributesContainer" data-testid={`product-attribute-${this.state.title.replace(/\s+/g, '-').toLowerCase()}`}>
          {this.props.attributes.map((attribute, index) => {
            const isSelected = this.state.selected === index;
            const className = this.state.type;
            const style = this.state.type === "swatch" ? { backgroundColor: attribute.value } : {};

            return (
              <div data-testid={`product-attribute-${this.state.title.replace(/\s+/g, '-').toLowerCase()}-${attribute.value.replace(/\s+/g, '-')}`}
                key={index}
                className={`${className} ${isSelected ? 'selected' : ''}`}
                style={style}
                onClick={() => this.handleSelect(index)}
              >
                {this.state.type === "text" ? attribute.value : null}
              </div>
            );
          })}
        </div>
      </div>
    );
  }

  handleSelect = (index) => {
    this.setState({ selected: index });
    if (this.props.onSelect) {
      this.props.onSelect(this.state.id, this.props.attributes[index].id);
    }
  };

}

window.Attributes = Attributes;
