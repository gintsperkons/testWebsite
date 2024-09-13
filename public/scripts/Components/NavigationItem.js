class NavigationItem extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
        <div className={`navItem ${this.props.selected? "selected" : ""}`} data-testid={`${this.props.selected? "active-category-link" : "category-link"}`}>
                <h3 href="#" onClick={this.props.onClick} >{this.props.itemName}</h3>
            </div>
        );
    }
}

window.NavigationItem = NavigationItem;
