class MainImage extends React.Component {
  render() {
    return (
      <div className="mainImageContainer">
        <img className="mainImage" src={this.props.image} alt="Main" />
      </div>
    );
  }
}

window.MainImage = MainImage;