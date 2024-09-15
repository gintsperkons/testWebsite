class NavigationItem extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
        <a href={`/${this.props.itemName}`} className={`navItem ${this.props.selected? "selected" : ""}`} data-testid={`${this.props.selected? "active-category-link" : "category-link"}`}>
                {this.props.itemName}
            </a>
        );
    }
}

window.NavigationItem = NavigationItem;
