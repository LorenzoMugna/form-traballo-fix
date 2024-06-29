import ReactDOM from 'react-dom/client';
import Form from './Form';
import { Box, CssBaseline, GlobalStyles, Grid, Paper, ThemeProvider, Typography, createTheme } from '@mui/material';
import { Fragment, useState } from 'react';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

const theme = createTheme({
  palette: {
    primary: {
      main: '#B6313A',
    },
    secondary: {
      main: '#545454',
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

const Elem = () => {
  const [formState, setFormState] = useState<"success" | "failure" | "insert">("insert");

  return (
    <Grid
      container
      spacing={0}
      direction="column"
      alignItems="center"
      justifyContent="center"
    >
      <Grid item xs={3}>
        <Paper elevation={4} sx={{backgroundColor:"white", pl:4, pr:4, pb:4}}>
          <Box
            width="640px"
            maxWidth="100%"
          >
            <img
              src="./LOGO-SABG-definitivo-3.png"
              alt="Sant'Anna Business Game"
              style={{width:"100%"}}
            />
            {
              (formState === "insert") ?
                <Form submitSuccess={() => setFormState("success")} submitFailure={() => setFormState("failure")}/>
              : (formState === "success") ?
                <Fragment>
                  <Typography align="center" color="secondary" variant="h4" sx={{mt:4,mb:2}}>Submission successful</Typography>
                  <Typography sx={{mb:4}}>We have received your submission. You will hear from us soon!</Typography>
                </Fragment>
              : (formState === "failure") ?
                <Fragment>
                  <Typography align="center" color="secondary" variant="h4" sx={{mt:4,mb:2}}>Submission error</Typography>
                  <Typography sx={{mb:4}}>There was an error in sending your submission. Please try again later</Typography>
                </Fragment>
              : "error"
            }
          </Box>
        </Paper>
      </Grid>
    </Grid>
  )
}

root.render(
  <ThemeProvider theme={theme}>
    <CssBaseline />
    <GlobalStyles
      styles={{
        body: { backgroundColor: "background.default" },
      }}
    />
    <Elem/>
  </ThemeProvider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
// reportWebVitals(console.log);
