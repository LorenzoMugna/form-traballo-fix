import ReactDOM from 'react-dom/client';
import Form from './Form';
import { Box, CssBaseline, GlobalStyles, Grid, Paper, ThemeProvider, Typography, createTheme } from '@mui/material';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

const theme = createTheme({
  palette: {
    primary: {
      main: '#B6313A',
    },
    secondary: {
      main: '#485766',
    },
    background: {
      default: 'white'
    }
  },
  components: {
    MuiInputBase: {
      defaultProps: {
        color:"primary"
      }
    },
    MuiInputLabel: {
      defaultProps:{
        color:"primary"
      }
    }
  },
});

root.render(
  <ThemeProvider theme={theme}>
    <CssBaseline />
    <GlobalStyles
      styles={{
        body: { backgroundColor: "background.default" },
      }}
    />
    <Grid
      container
      spacing={0}
      direction="column"
      alignItems="center"
      justifyContent="center"
    >
      <Grid item xs={3}>
        <Paper elevation={4} sx={{backgroundColor:"white", pl:4, pr:4}}>
          <Box
            component="img"
            alt="Sant'Anna Business Game"
            src="/LOGO-SABG-definitivo-3.png"
            sx={{mb:4, mt:4, width:"40vw"}}
          />
          <Typography align="center" color="secondary"><h1>Apply for our Business Game</h1></Typography>
          <Form />
        </Paper>
      </Grid>
    </Grid>
  </ThemeProvider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
// reportWebVitals(console.log);
