// main.js

// Define a simple React component
class MyComponent extends React.Component {
    componentDidMount() {
        console.log('MyComponent has been mounted!');
    }

    render() {
        return React.createElement('div', null, 'Hello, React!');
    }
}

// Render the React component into the root element
ReactDOM.render(
    React.createElement(MyComponent),
    document.getElementById('root')
);